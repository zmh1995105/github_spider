#!/usr/bin/perl
use strict;
use warnings;
use Data::Dumper;
use YAML;
use Text::Template;
use File::Basename qw/basename/;
use File::Path 'mkpath';
use File::Spec::Functions;
use Cwd 'getcwd';
use FindBin qw($Bin);
use lib "$Bin/../lib";
use K0U5UK3::Error qw($DEBUG $WARNING debug warning critical);
use K0U5UK3::Util qw(init_dir);

our $YAML = YAML::LoadFile("$Bin/../settings.yaml");

#-----------#
# SUB ROUTN #
#-----------#
sub msg($){
   my $msg = shift;
   print "[*] $msg\n";
}

sub generate_from_template($$){
   my $tmpl_file = shift;
   my $data = shift;

   my $template = Text::Template->new(SOURCE => "$tmpl_file");
   my $text = $template->fill_in(HASH => $data) or die "Faild fill in $tmpl_file\n";
   my $gen_file = basename $tmpl_file;

   my $write_file = catfile($YAML->{SETTING_DIR}, $gen_file);

   open my $fh, '>', $write_file or die "Faild write $write_file : $!\n";
   print $fh $text;
   close($fh);

   msg("$tmpl_file template file to $write_file");
   return $write_file;
}

#-------------#
# MAIN ROUTIN #
#-------------#
sub main(){
   # 解析対象PHPスクリプトを配置するディレクトリを作成する
   init_dir($YAML->{WEBROOT_DIR});
   # TRACELOG出力先ディレクトリを作成する
   init_dir($YAML->{TRACELOG_DIR});
   # 設定ファイル格納ディレクトリを作成する
   init_dir($YAML->{SETTING_DIR}); 
   # ログ格納ディレクトリを作成する
   init_dir($YAML->{LOG_DIR});

   my $sandbox_httpd_logfile = catfile($YAML->{LOG_DIR}, $YAML->{SANDBOX_HTTPD_LOGFILE});
   my $buitin_php_server_logfile = catfile($YAML->{LOG_DIR}, $YAML->{PHP_BUILTIN_SERVER_LOGFILE});

   # Templateからphp実行前処理と実行後処理を作成
   my $prepend_php = generate_from_template("./template/prepend.php", {TRACELOG_DIR => "$YAML->{TRACELOG_DIR}"});
   my $append_php = generate_from_template("./template/append.php", {});

   # Templateからphp.iniを作成
   my $custom_php = generate_from_template("./template/custom-php.ini", {PREPEND_PHP => "$prepend_php", APPEND_PHP => "$append_php"});

   # Templateからiptables.ruleを作成
   my $iptables_rule = generate_from_template("./template/iptables.rule", { SANDBOX_HTTPD_PORT  => "$YAML->{SANDBOX_HTTPD_PORT}" });

   # iptables設定の指示
   msg("以下のコマンドでSANDBOX_HTTPDとSSH以外の通信を遮断します。");
   msg("sudo iptables-restore $iptables_rule");
   msg("iptables設定をデフォルトに戻すには以下のコマンドを入力してください");
   msg("sudo /sbin/iptables -X");
   msg("sudo /sbin/iptables -P INPUT ACCEPT");
   msg("sudo /sbin/iptables -P OUTPUT ACCEPT");
   msg("sudo /sbin/iptables -P FORWARD ACCEPT");
   msg("sudo /sbin/iptables -F");

   if($YAML->{USE_SSL}){
      msg("HTTPSを使用するために秘密鍵、公開鍵、証明書を作成します。");
      system("openssl genrsa 2048 > server.key");
      system("openssl req -new -key server.key -out server.csr -subj '/C=JP/ST=Tokyo/L=Tokyo/O=Example Ltd./OU=Web/CN=example.com'");
      system("openssl x509 -in server.csr -days 365 -req -signkey server.key > server.crt");
      system("/bin/mv server.key server.csr server.crt $YAML->{SETTING_DIR}");
   } 

   if($YAML->{SANDBOX_HTTPD_ENGINE} eq 'APACHE'){
      # Apacheの設定ディレクトリを作成する
      init_dir($YAML->{APACHE_DIR});
      my $apache_conf = generate_from_template("./template/apache2.conf", {
         APACHE_DIR => $YAML->{APACHE_DIR},
         APACHE_USER => scalar getpwuid($>),
         APACHE_GROUP => scalar getgrgid($)),
         APACHE_ERR_LOGFILE => catfile($YAML->{LOG_DIR}, $YAML->{SANDBOX_HTTPD_ERRFILE}),
         APACHE_PORT => $YAML->{SANDBOX_HTTPD_PORT},
         APACHE_DOCUMENT_ROOT => $YAML->{WEBROOT_DIR},
         APACHE_ACCESS_LOGFILE => catfile($YAML->{LOG_DIR}, $YAML->{SANDBOX_HTTPD_LOGFILE}),
         SANDBOX_PSGI => catfile(getcwd(), "sandbox.psgi"),
         PHP_INI_FILE => $custom_php,
      });

      system("cp $apache_conf $YAML->{APACHE_DIR}"); 

      # 必要な設定ファイルをコピーする 
      system("cp -r /etc/apache2/mods-available $YAML->{APACHE_DIR}");
      system("cp -r /etc/apache2/mods-enabled $YAML->{APACHE_DIR}");
      # Apacheを稼働させる
      system("/usr/sbin/apache2 -d $YAML->{APACHE_DIR} -f apache2.conf");
   }elsif($YAML->{SANDBOX_HTTPD_ENGINE} eq 'PLACK'){
      # HTTPD_ENGINEにPLACKを使用する
      if($YAML->{USE_SSL}){
         # PLACKをHTTPSプロトコルで立ち上げる
         system("/usr/bin/plackup -s HTTP::Server::PSGI --ssl-key-file $YAML->{SETTING_DIR}/server.key " . 
               "--ssl-cert-file $YAML->{SETTING_DIR}/server.crt --ssl 1 sandbox.psgi " . 
               "--host $YAML->{SANDBOX_HTTPD_HOST} --port $YAML->{SANDBOX_HTTPD_PORT} >> $sandbox_httpd_logfile 2>&1 &"); 
      }else{
         # PLACKをHTTPプロトコルで立ち上げる
         system("/usr/bin/plackup sandbox.psgi --host $YAML->{SANDBOX_HTTPD_HOST} " . 
               "--port $YAML->{SANDBOX_HTTPD_PORT} >> $sandbox_httpd_logfile 2>&1 &");
      }
   }elsif($YAML->{SANDBOX_HTTPD_ENGINE} eq 'STARMAN'){
      # HTTPD_ENGINEにSTARMANを使用する
      if($YAML->{USE_SSL}){
         # STARMANをHTTPSプロトコルで立ち上げる
         system("/usr/bin/plackup -s Starman -a sandbox.psgi --ssl-key-file $YAML->{SETTING_DIR}/server.key " . 
               "--ssl-cert-file $YAML->{SETTING_DIR}/server.crt --ssl 1 " . 
               "--host $YAML->{SANDBOX_HTTPD_HOST} --port $YAML->{SANDBOX_HTTPD_PORT} >> $sandbox_httpd_logfile 2>&1 &");
      }else{
         # STARMANをHTTPプロトコルで立ち上げる
         system("/usr/bin/plackup -s Starman -a sandbox.psgi " . 
               "--host $YAML->{SANDBOX_HTTPD_HOST} --port $YAML->{SANDBOX_HTTPD_PORT} >> $sandbox_httpd_logfile 2>&1 &");
      }
   }

   if($YAML->{SANDBOX_HTTPD_ENGINE} ne 'APACHE'){
      # APACHE以外のHTTPD_ENGINEを使用するならPHP_BUILTIN_SERVERが必要
      system("/usr/bin/php -t $YAML->{WEBROOT_DIR} -S $YAML->{PHP_BUILTIN_SERVER_HOST}:$YAML->{PHP_BUILTIN_SERVER_PORT} " . 
            "-c $custom_php >> $buitin_php_server_logfile 2>&1 &");
   }
}

main ();


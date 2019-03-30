#!/usr/bin/env perl
use strict;
use warnings;
use YAML;
use Plack::Request;
use File::Copy;
use Digest::MD5;
use HTTP::Request::Common;
use LWP::UserAgent;
use File::Path 'mkpath';
use Data::Dumper;
use JSON qw(encode_json decode_json);
use File::Temp qw/ tempfile tempdir /; 
use FindBin qw($Bin);
use lib "$Bin/../lib";
use K0U5UK3::Error qw($DEBUG $WARNING debug warning critical);
use K0U5UK3::Util qw(read_file cleanup get_md5);
use K0U5UK3::OPWD qw();

our $YAML = YAML::LoadFile("$Bin/../settings.yaml");

#------------#
# SUB ROUTIN # 
#------------#

#---------------------------------------------------------------------
# parse_tracelogはハッシュリファレンスとリストリファレンスを返す。
# ハッシュリファレンスは関数名と呼び出し回数を保持しており
# リストリファレンスは関数を呼び出し順に関数名とパラメータを保持する
#---------------------------------------------------------------------
sub parse_tracelog($){
   my $tracelog = shift;
   my %func_count;
   my @stack_trace;
   my ($START_FLAG, $END_FLAG);

   open my $fh, '<', $tracelog or die "Failed open $tracelog : $!\n";
   while(<$fh>){
      if($_ =~ /^TRACE\sSTART/){ $START_FLAG=1};
      if($_ =~ /^TRACE\sEND/){   $END_FLAG=1  };
      if($START_FLAG && !$END_FLAG){
         my @col = split("\t", $_);
         if(defined $col[2] && $col[2] eq '0'){
            #関数呼び出しのみを解析対象とする。
            my $func_name = $col[5];
            # 関数呼び出し回数集計
            $func_count{$func_name}++;
            # stack_trace作成
            my @param;
            if($func_name eq 'eval'){
               #evalの場合は7番にパラメータが入る
               push(@param,$col[7]);               
            }else{
               @param = @col[11..$#col];
            }
            push(@stack_trace, [$func_name, @param]);
         }
      }
   }
   close($fh);

   return (\%func_count, \@stack_trace);
}



sub escape2control($){
   my $string = shift;
   # 先頭と行末のシングルクォーテションを削除
   $string =~ s/^\'//;
   $string =~ s/\'$//;

   # エスケープシーケンスを制御文字に変換
   $string =~ s/\\r\\n/\x{0a}/g;
   $string =~ s/\\n/\x{0a}/g;
   $string =~ s/\\t/\x{09}/g; 

   $string =~ s/\\//g;
   return $string;
}

sub deobfusucate($){
   my $stack_trace = shift;
   my @ret;

   foreach my $tmp (@$stack_trace){
      my $deobfusucate;
      if($tmp->[0] eq 'eval'){
         $deobfusucate = escape2control($tmp->[1]);
      }
      if($tmp->[0] eq 'create_function'){
         $deobfusucate = escape2control($tmp->[2]);
      }
      if($tmp->[0] eq 'assert'){
         $deobfusucate = escape2control($tmp->[1]);
      }
      push(@ret, $deobfusucate);
   }
   return \@ret;
}

sub strip_php_code($){
   my $code = shift;
   my $fh = new File::Temp();
   my $file = $fh->filename;
   print $fh $code;
   my $strip = qx{ /usr/bin/php -w $file } ;
   return $strip;
}

sub detect_obfuscate($){
   my $info = shift;
   my @msg;
   
   # このフラグが両方立った時、難読化ファイルとして判定する
   # これは復号処理のための関数と、
   # 再評価のための関数が難読化ファイルの実行のために必要であるため
   my ($eval_flag, $deobfuscate_flag);

   # コード再評価のための関数
   # preg_replaceのeオプションは内部でevalとして処理されるので含めない
   my @eval_func = qw(eval assert create_function);

   # コード復号化のための関数
   my @deobfuscate_func = qw(base64_decode gzinflate str_rot13 
                             gzuncompress strrev rawurldecode);

   map{ 
      my $key = $_;
      if(grep { $key eq $_ } @eval_func){
         my $count = $info->{$key};
         push(@msg, "$key($count)");
         $eval_flag++;
      }
   } keys %$info;

   # コード再評価関数の使用に基づきスコアリング
   map{ 
      my $key = $_;
      if(grep { $key eq $_ } @deobfuscate_func){
         my $count = $info->{$key};
         push(@msg, "$key($count)");
         $deobfuscate_flag++;
      }
   } keys %$info;

   if($eval_flag && $deobfuscate_flag){
      return (1, \@msg);
   }else{
      return (0, \@msg);
   }
}

sub detect_webshell($){
   my $codes = shift;
   my $flag=0;
   my @msg;

   # 以下の関数がひとつでも使用されているならwebshellとみなす
   # ここにはpreg_replaceを含めるべきではないか？
   #my @webshell_codes = qw(
   #   system exec passthru shell_exec popen proc_open 
   #   pcntl_exec eval assert create_function
   #);

   # 検知関数をこれだけにすると誤検知はほぼなくなる。
   # しかしweebvelyなどの外からwebshell_codeが渡ってくるものは検知できなくなる
   my @webshell_codes = qw(
      system exec passthru shell_exec popen proc_open pcntl_exec    
   );

   foreach my $code (@$codes){
      next unless defined $code;
      my $strip = strip_php_code($code);            
      foreach my $webshell_code (@webshell_codes){
         my $count = scalar( () = $strip =~ /[^\w]$webshell_code\(.+\)/g);
         if($count){  
            push(@msg, "$webshell_code($count)");
            $flag++;
         }
      }      
   }

   return ($flag,\@msg);
}

#-------------#
# MAIN ROUTIN #
#-------------#
sub main(){
   my $app = sub {
      # obscan.plからのパラメータ取得
      my $req = Plack::Request->new(shift);

      my $uploads = $req->uploads;
      my $file_name = $uploads->{data}->{filename};    # 対象ファイル名
      my $tmp_path = $uploads->{data}->{tempname};    # 対象ファイルの一時保存先
      my $client_md5 = $req->param('md5');        # 対象ファイルのCLIENT側で取得したmd5
      my $mode = $req->param('mode');             # mode

      # mode値のチェック
      my @allow_mode = qw(detect-obfuscate detect-webshell deobfuscate tracelog viewfunc);
      unless(grep {$mode eq $_} @allow_mode){
         return [ 500, [ 'Content-Type' => 'text/plain' ], [ "Unexcepted mode paramaeter" ], ];
      }

      #--------------#
      # 解析準備処理 #
      #--------------#

      # plackによりアップロードされたファイルはテンポラリファイルとして所定の位置に配置される。
      # これを解析場所に配置する。
      unless(-f $tmp_path){
         # もしテンポラリファイルが存在しないならエラーを返す
         return [ 500, [ 'Content-Type' => 'text/plain' ], [ "Not found temporary file" ], ];
      }
      
      # クライアントから渡されたファイル名を元に解析場所に配置した完全なファイルパスを取得する       
      my $ana_path = $YAML->{WEBROOT_DIR} . $file_name;

      # テンポラリファイルを解析場所に配置する
      unless(move $tmp_path, $ana_path){
         # テンポラリファイルを解析場所に配置できないなら、
         # テンポラリファイルを削除してエラーを返す。
         cleanup($tmp_path);
         return [ 500, [ 'Content-Type' => 'text/plain' ], [ "Failed move $tmp_path to $ana_path : $!" ], ];
      }

      # 解析場所に配置したファイルを実行可能な権限に変更する
      unless(chmod 0666, $ana_path){
         # 権限変更ができないなら解析場所に配置したファイルを削除して、エラーを返す
         cleanup($ana_path);
         return [ 500, [ 'Content-Type' => 'text/plain' ], [ "Failed chmod $ana_path : $!" ], ];
      }

      # クライアントから渡されたmd5値とサーバ上で取得したmd5値が一致するのかを確認する。      
      unless($client_md5 eq get_md5($ana_path)){
         # md5が一致しないならファイルのアップロード時に壊れているのでファイルを削除してエラーを返す
         cleanup($ana_path);
         return [ 500, [ 'Content-Type' => 'text/plain' ], [ "upload file is corrupted." ], ];
      }      

      #------------------#
      # TRACELOG取得処理 # 
      #------------------#

      my $tracelog_file;

      # tracelog取得処理は未知数のエラーが発生する可能性が高いのでトラップする
      eval{
         # ブラウザの作成
         my $ua = LWP::UserAgent->new;
         $ua->agent("OPWD CLIENT ;-)");
         $ua->timeout($YAML->{SANDBOX_UA_TIMEOUT});
   
         # 解析対象ファイルを実行できるURIを構築する
         my $ana_uri;
         if($YAML->{SANDBOX_HTTPD_ENGINE} eq 'APACHE'){
            $ana_uri = "http://127.0.0.1:".$YAML->{SANDBOX_HTTPD_PORT}."/".$file_name;
         }else{
            $ana_uri = "http://".$YAML->{PHP_BUILTIN_SERVER_HOST}.":".$YAML->{PHP_BUILTIN_SERVER_PORT}."/".$file_name;
         } 
   
         # tracelogファイルパスを取得する
         $tracelog_file = "$YAML->{TRACELOG_DIR}".$file_name.".xt";
   
         # 解析PHPをApache経由で実行し、Xdebugにtracelogを吐かせる
         my $response = $ua->get("$ana_uri");
      };

      if($@){
         cleanup($ana_path);
         cleanup($tracelog_file);
         return [ 500, [ 'Content-Type' => 'text/plain' ], [ "SANDBOX browser eval trap : $@" ], ];
      }

      #------------------#
      # TRACELOG解析処理 #
      #------------------#

      # $func_infoは関数名と出現回数を記録したハッシュリファレンス
      # $stack_traceは関数呼び出しと引数を順序を考慮し格納したリストリファレンス
      my ($func_info,$stack_trace) = parse_tracelog($tracelog_file);
      # tracelogの生テキスト
      my $trace_text = read_file($tracelog_file);

      # TRACELOGを取得したら解析対象ファイルやTRACELOGファイルは必要ないので削除する
      cleanup($ana_path);
      cleanup($tracelog_file);

      #--------------------------#
      # モードにより返り値を分岐 #
      #--------------------------#

      my %ret;

      # [viewfunc]は呼ばれた関数の一覧とその回数を出力する
      if($mode eq 'viewfunc'){
         %ret = ( 'mode' => 'viewfunc', 'body' => $func_info,); 
         return [ 200, [ 'Content-Type' => 'text/plain' ], [ encode_json( \%ret ) ], ];
      }

      # [tracelog]はxdebugにより取得されたtracelogをそのまま返す 
      if($mode eq 'tracelog'){
         %ret = ( 'mode' => 'tracelog', 'body' => $trace_text,);
         return [ 200, [ 'Content-Type' => 'text/plain' ], [ encode_json( \%ret ) ], ];
      }     

      # [detect-obfuscate]は難読化されたファイルか否かを判定し、結果を返す
      if($mode eq 'detect-obfuscate'){
         my ($flag, $msg) =  detect_obfuscate($func_info); 
         if($flag){
            # 難読化判定
            %ret = ( 'mode' => 'detect-obfuscate', 'body' => "OBFUSCATE[o] INFO[" . join(", ", @$msg) ."]");
         }else{
            # 難読化されていない
            %ret = ( 'mode' => 'detect-obfuscate', 'body' => "OBFUSCATE[x] INFO[" . join(", ", @$msg) ."]");
         }
         return [ 200, [ 'Content-Type' => 'text/plain' ], [ encode_json( \%ret ) ], ];
      }

      # [deobfuscate]は再評価処理に渡された引数を全て返す
      if($mode eq 'deobfuscate'){
         %ret = ( 'mode' => 'deobfuscate', 'body' => deobfusucate($stack_trace),);
         return [ 200, [ 'Content-Type' => 'text/plain' ], [ encode_json( \%ret ) ], ];
      }

      # [detect-webshell]は難読化されたwebshellか否かを判定し、結果を返す。
      if($mode eq 'detect-webshell'){
         my ($obfuscate_flag, $obfuscate_msg) =  detect_obfuscate($func_info); 
         unless($obfuscate_flag){
            # 難読化されていないファイル
            %ret = ( 'mode' => 'detect-obfuscate', 'body' => "OBFUSCATE[x] INFO[" . join(", ", @$obfuscate_msg) ."]");
            return [ 200, [ 'Content-Type' => 'text/plain' ], [ encode_json( \%ret ) ], ];
         }

         # 以降難読化されているファイルであるためwebshellか否かの判定を行う
         my ($webshell_flag, $webshell_msg) = detect_webshell(deobfusucate($stack_trace));
         unless($webshell_flag){
            # 難読化されているがwebshellではない
            %ret = ( 'mode' => 'detect-obfuscate', 'body' => "OBFUSCATE[o] WEBSHELL[x] INFO[" . join(", ", @$obfuscate_msg, @$webshell_msg) ."]");
         }else{
            # 難読化されているWebShellである
            %ret = ( 'mode' => 'detect-obfuscate', 'body' => "OBFUSCATE[o] WEBSHELL[o] INFO[" . join(", ", @$obfuscate_msg, @$webshell_msg) ."]");
         }

         return [ 200, [ 'Content-Type' => 'text/plain' ], [ encode_json( \%ret ) ], ];
      }
   };

   return $app;
}

main();


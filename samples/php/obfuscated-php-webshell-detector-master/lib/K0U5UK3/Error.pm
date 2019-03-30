package K0U5UK3::Error;
require Exporter;
use Exporter;
@ISA = qw(Exporter);
@EXPORT_OK = qw($DEBUG $WARNING debug warning critical);
use Carp qw(carp cluck croak confess);
use strict;
use warnings;

our $DEBUG=0;
our $WARNING=0;

sub timestamp($){
   my $unixtime = shift;
   my ($sec, $min, $hour, $mday, $mon, 
      $year, $wday, $yday, $isdst) = localtime($unixtime);

   my $fmt = "%04d/%02d/%02d(%s) %02d:%02d:%02d";
   my $timestamp =  sprintf($fmt, $year+1900,$mon+1,$mday,substr(localtime, 0, 3), $hour,$min,$sec);
   return $timestamp;
}

# debugは単純にメッセージだけを出力する
# warningはメッセージと実行行を出力する
# ciriticalはメッセージと実行行を出力して終了する。もしくは$@に値をセットする
sub debug($){
   my $msg = shift;
   my $ts = timestamp(time);
   print STDERR "[DEBUG][$ts] $msg\n" if $DEBUG;
}

sub warning($){
   my $msg = shift;
   my $ts = timestamp(time);
   carp "[WARNING][$ts] $msg\n" if $WARNING;
}

sub critical($){
   my $msg = shift;
   my $ts = timestamp(time);
   croak "[CRITICAL][$ts] $msg\n";
}

1;


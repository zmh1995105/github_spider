#!/usr/bin/perl
use strict;
use warnings;
use YAML qw(Dump Bless);

my $hash = {
   'WEBROOT'  => "/tmp/obfusucated-php-detector/webroot/",
   'TRACELOG' => "/tmp/obfusucated-php-detector/tracelog/",
};

print Dump $hash;



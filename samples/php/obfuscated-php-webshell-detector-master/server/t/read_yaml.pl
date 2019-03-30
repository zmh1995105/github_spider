#!/usr/bin/perl
use strict;
use warnings;
use Data::Dumper;
use YAML qw(LoadFile);

my $hash =  LoadFile("./observ.yaml");

print Dumper($hash);

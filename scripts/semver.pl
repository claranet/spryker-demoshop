#!/usr/bin/env perl
# 20170519 <fabian.doerk@de.clara.net>
# Bumps either major, minor or patch level of semver scheme. The remaining
# lower level version digits will be resetted to 0.
use strict;
my $re_valid = qr/^(major|minor|patch)$/;
my $re_digits = qr/^(\d+)\.(\d+)\.(\d+)$/;
push @ARGV, 'patch' if $#ARGV == 0;
die "Wrong arguments!\nUsage: $0 <version> [{major,minor,patch}]\n" if scalar @ARGV != 2 or $ARGV[1] !~ /^(major|minor|patch)$/;
die "Wrong format for semantic version: $ARGV[0]\n" if $ARGV[0] !~ $re_digits;
my ($ver, $raise) = @ARGV;
my %idx=(); my $i=0;
map{$idx{$_}=$i++} qw(major minor patch);
my @m=($ver =~ $re_digits);
$m[$idx{$raise}]++;
map{$m[$_]=0} $idx{$raise}+1..$#m;
print join(".", @m)."\n"

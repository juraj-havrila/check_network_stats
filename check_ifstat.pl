#!/usr/bin/perl
#Nagios plugin for collecting Network Statistics Data
#https://github.com/juraj-havrila/check_network_stats
#Juraj Havrila, 2018-05-18
#
use strict;
use warnings;

my %HoH_nic_stats;
my $message = "OK: Network Interface statistics collected successfully. | ";
# 0| OK         1|WARNING       2|CRITICAL      3|UNKNOWN
my $return_code=3;
my $raw_json=`/usr/sbin/ifstat -j 2>&1`;
if ($?) {
    $return_code=1;
    print "WARNING: Check failed to execute: ERROR Code $? :  $! \n";
    exit $return_code;
    }
$raw_json =~ s/:/=>/g;
%HoH_nic_stats= %{eval $raw_json};
    foreach my $nic_grp (keys %HoH_nic_stats) {
        foreach my $nic_id (keys $HoH_nic_stats{$nic_grp}) {
            foreach my $metric (keys $HoH_nic_stats{$nic_grp}{$nic_id}) {
                $message = $message . $nic_id . ':' . $metric . '=' . $HoH_nic_stats{$nic_grp}{$nic_id}{$metric} . 'c ';
            }
        }
    }
$return_code=0;
print $message . "\n";
exit $return_code;
1;

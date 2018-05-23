<?php
/*
Version 1.0
PNP4Nagios Template file for 'check_ifstat.pl'

Juraj Havrila, 23.05.2018
https://github.com/juraj-havrila/check_network_stats
*/

$all_nics=array();

foreach ($this->DS as $KEY=>$VAL) {
	$my_name=$VAL['NAME'];
	$position[$my_name]=$KEY+1;
        list($my_interface,$my_metrics) = explode("_", $my_name,2);
        if (!in_array($my_interface, $all_nics))
            {
            $all_nics[] = $my_interface; 
            }
	}




$pom = 1;

foreach ($all_nics as &$my_nic) {

$ds_name[$pom] = "NIC Data Throughput ($my_nic)";
$opt[$pom] = "--title \"$hostname ($my_nic) - Bytes Sent (TX) / Received (RX)\"";
$opt[$pom] .= " --vertical-label \"[Bytes] \" ";
$opt[$pom] .= " --slope-mode ";

$my_pos=$position[$my_nic."_tx_bytes"];
$def[$pom] = rrd::def("TX_BYTES", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$my_pos=$position[$my_nic."_rx_bytes"];
$def[$pom] .= rrd::def("RX_BYTES", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$def[$pom] .= rrd::cdef("NEG_RX_BYTES","RX_BYTES,-1,*");
$my_var='TX_BYTES (SENT)';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("TX_BYTES",'#3399ff');
$def[$pom] .= rrd::line1("TX_BYTES",'#0080ff',$label);
$def[$pom] .= rrd::gprint("TX_BYTES",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='RX_BYTES (RECEIVED)';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("NEG_RX_BYTES",'#00ffff');
$def[$pom] .= rrd::line1("NEG_RX_BYTES",'#00cccc',$label);
$def[$pom] .= rrd::gprint("RX_BYTES",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
++$pom;

$ds_name[$pom] = "NIC Statistics ($my_nic)";
$opt[$pom] = "--title \"$hostname ($my_nic) - Packet statistics\"";
$opt[$pom] .= " --vertical-label \"[Packets] \" ";
$opt[$pom] .= " --slope-mode ";

$my_pos=$position[$my_nic."_tx_packets"];
$def[$pom] = rrd::def("TX_PACKETS", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$my_pos=$position[$my_nic."_tx_errors"];
$def[$pom] .= rrd::def("TX_ERRORS", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$my_pos=$position[$my_nic."_tx_dropped"];
$def[$pom] .= rrd::def("TX_DROPPED", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$my_pos=$position[$my_nic."_multicast"];
$def[$pom] .= rrd::def("MULTICAST", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$my_pos=$position[$my_nic."_collisions"];
$def[$pom] .= rrd::def("COLLISIONS", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$my_pos=$position[$my_nic."_rx_packets"];
$def[$pom] .= rrd::def("RX_PACKETS", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$def[$pom] .= rrd::cdef("NEG_RX_PACKETS","RX_PACKETS,-1,*");
$my_pos=$position[$my_nic."_rx_errors"];
$def[$pom] .= rrd::def("RX_ERRORS", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$def[$pom] .= rrd::cdef("NEG_RX_ERRORS","RX_ERRORS,-1,*");
$my_pos=$position[$my_nic."_rx_dropped"];
$def[$pom] .= rrd::def("RX_DROPPED", $RRDFILE[$my_pos], $DS[$my_pos], "AVERAGE");
$def[$pom] .= rrd::cdef("NEG_RX_DROPPED","RX_DROPPED,-1,*");

$my_var='TX_PACKETS (SENT)';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("TX_PACKETS",'#009900');
$def[$pom] .= rrd::line1("TX_PACKETS",'#006600',$label);
$def[$pom] .= rrd::gprint("TX_PACKETS",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='RX_PACKETS (RECEIVED)';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("NEG_RX_PACKETS",'#40bf40');
$def[$pom] .= rrd::line1("NEG_RX_PACKETS",'#339933',$label);
$def[$pom] .= rrd::gprint("RX_PACKETS",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='TX_ERRORS';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("TX_ERRORS",'#cc0000');
$def[$pom] .= rrd::line1("TX_ERRORS",'#990000',$label);
$def[$pom] .= rrd::gprint("TX_ERRORS",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='RX_ERRORS';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("NEG_RX_ERRORS",'#ff6666');
$def[$pom] .= rrd::line1("NEG_RX_ERRORS",'#ff3333',$label);
$def[$pom] .= rrd::gprint("RX_ERRORS",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='TX_DROPPED';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("TX_DROPPED",'#cc6600');
$def[$pom] .= rrd::line1("TX_DROPPED",'#994d00',$label);
$def[$pom] .= rrd::gprint("TX_DROPPED",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='RX_DROPPED';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("NEG_RX_DROPPED",'#ffb366');
$def[$pom] .= rrd::line1("NEG_RX_DROPPED",'#ff9933',$label);
$def[$pom] .= rrd::gprint("RX_DROPPED",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='MULTICAST';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("MULTICAST",'#99b3e6');
$def[$pom] .= rrd::line1("MULTICAST",'#1f3d7a',$label);
$def[$pom] .= rrd::gprint("MULTICAST",array("LAST","MAX","AVERAGE"),"%7.0lf") ;
$my_var='COLLISIONS';
$label = rrd::cut($my_var,23);
$def[$pom] .= rrd::area("COLLISIONS",'#e699ff');
$def[$pom] .= rrd::line1("COLLISIONS",'#ac00e6',$label);
$def[$pom] .= rrd::gprint("COLLISIONS",array("LAST","MAX","AVERAGE"),"%7.0lf") ;

++$pom;

}


?>

<?php
	error_reporting(0);
	$tanggal=date('dmY');
	$kunci1= 's3h44t'.$tanggal;
	$kunci = md5($kunci1);
		
	$msg = array("kunci" => $kunci);

	echo json_encode($msg);
?>

				
 		

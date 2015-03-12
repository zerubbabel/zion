<?php
	require ('../../../include/init.inc.php');	
	$os_unit=$_GET['os_unit'];
	$datas=Outsource::getOsStocks($os_unit);
	echo json_encode($datas);	
?>
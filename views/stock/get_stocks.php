<?php
	require ('../../include/init.inc.php');	
	$loc_id=$_GET['loc_id'];
	$datas=Stock::getStocks($loc_id);
	echo json_encode($datas);	
?>
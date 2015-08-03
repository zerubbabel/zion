<?php
	require ('../../include/init.inc.php');	
	$loc_id=$_GET['loc_id'];
	$product_name=$_GET['product_name'];
	$bin=$_GET['bin'];
	$datas=Stock::getStocks($loc_id,$product_name,$bin);
	echo json_encode($datas);	
?>
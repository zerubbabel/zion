<?php
	require ('../../include/init.inc.php');	
	$loc_id=$_GET['loc_id'];
	$product_id=$_GET['product_id'];
	$product_name=$_GET['product_name'];
	$bin=$_GET['bin'];
	$datas=Stock::viewStocks($loc_id,$product_id,$product_name,$bin);
	echo json_encode($datas);	
?>
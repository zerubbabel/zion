<?php
	$datas=array( 
		array("id"=>"1","name"=>"Desktop Computer","note"=>"note","stock"=>"Yes","ship"=>"FedEx","sdate"=>"2007-12-03"),
		array("id"=>"2","name"=>"Laptop","note"=>"Long text ","stock"=>"Yes","ship"=>"InTime","sdate"=>"2007-12-03"));
	// 示例：
	require_once '../config.php';
	require_once '../include/medoo.min.php';
	 
	$database = new medoo($db_path);
	
	//$datas = $database->select("sale_order_mst","*");
	echo json_encode($datas);
	
?>
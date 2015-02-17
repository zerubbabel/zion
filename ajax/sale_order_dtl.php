<?php
	$id=$_POST['id'];
	// 示例：
	require_once '../config.php';
	require_once '../include/medoo.min.php';
	 
	$database = new medoo($db_path);
	
	$datas = $database->select("sale_order_dtl",
		["[>]products"=>["product_id"=>"id"]],
		["product_name","qty"],
		["mst_id"=>$id]);
	//var_dump($database->error());
	echo json_encode($datas);

	
?>
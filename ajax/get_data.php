<?php
/*
	require_once '../config.php';
	require_once '../include/medoo.min.php';
	 
	$database = new medoo($db_path);
	
	$datas = $database->select("sale_order_mst",
		["[>]customers"=>["cust_id"=>"id"],
		"[>]users"=>["op_id"=>"user_id"]],
		["sale_order_mst.id","cust_id","createday","op_id","cust_name","user_name"]);
		*/
	require ('../include/init.inc.php');
	$datas = Sale::getAllSaleOrderMst();
	echo json_encode($datas);
	
?>
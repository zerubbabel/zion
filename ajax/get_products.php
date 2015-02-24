<?php
	require_once '../config.php';
	require_once '../include/medoo.min.php';
	 
	$database = new medoo($db_path);
	
	$datas = $database->select("products",["id","product_name(name)"]);
	echo json_encode($datas);
	
?>
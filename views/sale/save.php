<?php
	
	
	$createday=$_POST['createday'];
	$cust_id=$_POST['cust_id'];
	$op_id=$_POST['op_id'];
	
	require_once '../../config.php';
	require_once '../../include/medoo.min.php';
	 
	$database = new medoo($db_path);

	$result=$database->insert("sale_order_mst", [
		"createday" => $createday,
		"cust_id" => $cust_id,
		"op_id" => $op_id
		]);
	if ($result>0)
	//$result=array('status'=>false);
	{	
		echo json_encode(array('status'=>true)); 
	}
	else {
		echo json_encode(array('status'=>false)); 
	}
	
?>
<?php
	$oper=$_POST['oper'];
	switch ($oper) {
		case 'edit':
			editOrder();
			break;
		case 'add':
			addOrder();
			break;
		case 'del':
			delOrder();
			break;
		default:
			break;
	}
function delOrder(){
	$id=$_POST['id'];	
	require_once '../../config.php';
	require_once '../../include/medoo.min.php';
	$database = new medoo($db_path);
	$result=$database->delete("sale_order_mst",
		["AND"=>["id"=>$id]]);
	if ($result>0)
	{	
		echo json_encode(array('status'=>true)); 
	}
	else {
		echo json_encode(array('status'=>false)); 
	}
}
function editOrder(){
	$id=$_POST['id'];
	$cust_id=$_POST['cust_name'];
	require_once '../../config.php';
	require_once '../../include/medoo.min.php';
	$database = new medoo($db_path);
	$result=$database->update("sale_order_mst",
		["cust_id"=>$cust_id],
		["id"=>$id]
		);
	if ($result>0)
	{	
		echo json_encode(array('status'=>true)); 
	}
	else {
		echo json_encode(array('status'=>false)); 
	}
}
function addOrder()	{
	$createday=date('Y-n-j G:i:s');//$_POST['createday'];
	$cust_id=$_POST['cust_name'];
	session_start();
	$op_id=$_SESSION['user_id'];//$_POST['op_id'];
	
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
}
	
?>
<?php
	require ('../../include/init.inc.php');

	$oper=$_POST['oper'];
	switch ($oper) {
		case 'edit':
			edit();
			break;
		case 'add':
			add();
			break;
		case 'del':
			stop();
			break;
		default:
			break;
	}
function stop(){//状态status改为0，停用
	$id=$_POST['id'];	
	$result=Sale::stopCustomer($id);	
	echo json_encode($result); 
}
function edit(){
	$id=$_POST['id'];
	$cust_name=$_POST['cust_name'];
	$type_id=$_POST['type_name'];	
	$result=Sale::updateCustomer($id,$cust_name,$type_id);	
	echo json_encode($result); 
}
function add()	{
	$cust_name=$_POST['cust_name'];
	$type_id=$_POST['type_name'];	
	$result=Sale::addCustomer($cust_name,$type_id);	
	echo json_encode($result); 
}
	
?>
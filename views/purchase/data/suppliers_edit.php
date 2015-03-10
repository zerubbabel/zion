<?php
	require ('../../../include/init.inc.php');

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
	$result=Purchase::stopSupplier($id);	
	echo json_encode($result); 
}
function edit(){
	$id=$_POST['id'];
	$supplier_name=$_POST['supplier_name'];
	$type_id=$_POST['type_name'];	
	$result=Purchase::updateSupplier($id,$supplier_name,$type_id);	
	echo json_encode($result); 
}
function add()	{
	$supplier_name=$_POST['supplier_name'];
	$type_id=$_POST['type_name'];	
	$result=Purchase::addSupplier($supplier_name,$type_id);	
	echo json_encode($result); 
}
	
?>
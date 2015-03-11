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
	$result=Outsource::stopOs_unit($id);	
	echo json_encode($result); 
}
function edit(){
	$id=$_POST['id'];
	$Os_unit_name=$_POST['name'];
	$type_id=$_POST['type_name'];	
	$result=Outsource::updateOs_unit($id,$Os_unit_name,$type_id);	
	echo json_encode($result); 
}
function add()	{
	$Os_unit_name=$_POST['name'];
	$type_id=$_POST['type_name'];	
	$result=Outsource::addOs_unit($Os_unit_name,$type_id);	
	echo json_encode($result); 
}
	
?>
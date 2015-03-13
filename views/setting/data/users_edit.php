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
	$table='users';
	$where=array('user_id'=>$id);
	$data=array('status'=>0);
	$result=Db::updateRecord($table,$data,$where);	
	echo json_encode($result); 
}
function edit(){
	$id=$_POST['id'];
	$user_name=$_POST['user_name'];
	$group=$_POST['group_name'];
	$table='users';
	$where=array('user_id'=>$id);
	$data=array('user_name'=>$user_name,'user_group'=>$group);
	$result=Db::updateRecord($table,$data,$where);
	echo json_encode($result); 
}
function add()	{
	$user_name=$_POST['user_name'];
	$group=$_POST['group_name'];	
	$table='users';
	$data=array('user_name'=>$user_name,'user_group'=>$group);
	$result=Db::insertRecord($table,$data);	
	echo json_encode($result); 
}
	
?>
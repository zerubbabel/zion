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
	$result=User::stopUser($id);	
	echo json_encode($result); 
}
function edit(){
	$id=$_POST['id'];
	$user_name=$_POST['user_name'];
	$group=$_POST['group'];	
	$result=User::updateUser($id,$user_name,$group);	
	echo json_encode($result); 
}
function add()	{
	$user_name=$_POST['user_name'];
	$group=$_POST['type_name'];	
	$result=User::addUser($user_name,$group);	
	echo json_encode($result); 
}
	
?>
<?php
	require ('../../../include/init.inc.php');

	$oper=$_POST['oper'];
	switch ($oper) {
		case 'edit':
			edit();
			break;
		default:
			break;
	}

function edit(){
	$id=$_POST['id'];
	$deliveryday=$_POST['deliveryday'];
	$status=$_POST['status'];	
	$result=Outsource::updateOsOrderById($id,$deliveryday,$status);	
	echo json_encode($result); 
}
?>
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
	$status=$_POST['status'];	
	$result=Work::updateWorkDrawById($id,$status);	
	echo json_encode($result); 
}
?>
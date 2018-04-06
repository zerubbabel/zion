<?php
	require ('../../include/init.inc.php');

	$oper=$_POST['oper'];
	switch ($oper) {
		case 'del':
			del();
			break;
		default:
			break;
	}
function del(){
	$id=$_POST['id'];	
	$result=Sale::delSaleOrder($id);	
	echo json_encode($result); 
}
	
?>
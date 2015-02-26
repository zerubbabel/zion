<?php
	require ('../../include/init.inc.php');
	$oper=$_GET['q'];

	switch ($oper) {
		case 'dtl':
			get_dtl();
			break;
		
		default:
			# code...
			break;
	}

	function get_dtl(){
		$id=$_GET['id'];
		$datas=Sale::getSaleOrderDtlById($id);
		echo json_encode($datas);
	}
?>
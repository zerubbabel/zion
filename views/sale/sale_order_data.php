<?php
	require ('../../include/init.inc.php');
	$oper=$_GET['q'];

	switch ($oper) {
		case 'dtl':
			get_dtl();
			break;
		case 'custProduct':
			$cust_id=$_GET['cust_id'];
			custProduct($cust_id);
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

	function custProduct($cust_id){
		$cust_id=$_GET['cust_id'];
		$datas=Sale::custProduct($cust_id);
		echo json_encode($datas);
	}
?>
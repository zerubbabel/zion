<?php

	require ('../include/init.inc.php');
	$para=$_GET['para'];
	switch ($para['method']) {
		case 'saleMstById':
			$data = Sale::getSaleOrderMstById($para['id']);
			echo json_encode($data);
			break;
		case 'saleDtlById':
			$data = Sale::getSaleOrderDtlById($para['id']);
			echo json_encode($data);
			break;
		default:
			# code...
			break;
	}

?>	
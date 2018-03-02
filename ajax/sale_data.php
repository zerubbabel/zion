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
		case 'saleOutAllBySaleOrderId':
			$data = Sale::getSaleOutAllBySaleOrderId($para['id']);
			echo json_encode($data);
			break;	
		case 'getLoc':
			$data = Baseinfo::getLoc();
			echo json_encode($data);
			break;	
		case 'getCust':
			$data = Baseinfo::getCust();
			echo json_encode($data);
			break;	
		/*case 'getSaleOutDtlById':
			$data = Baseinfo::getDtlById($para['id'],'sale_out');
			echo json_encode($data);
			break;	*/
		default:
			# code...
			break;
	}

?>	
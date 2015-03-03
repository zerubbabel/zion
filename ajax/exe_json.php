<?php

	require ('../include/init.inc.php');
	$para=$_POST['para'];
	switch ($para['method']) {
		case 'insertSaleOutOrder':
			$data = Sale::insertSaleOutOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;
		case 'getSaleOutList':
			$data = Sale::getSaleOutList();
			echo json_encode($data);
			break;
		case 'getSaleOutDtlById':
			$data = Sale::getSaleOutDtlById($para['id']);
			echo json_encode($data);
			break;
		case 'getStockById':
			$data = Stock::getStockById($para['loc_id'],$para['product_id']);
			echo json_encode($data);
			break;	
		case 'insertWorkDrawOrder':
			$data = Work::insertWorkDrawOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;
		default:
			# code...
			break;
	}

?>	
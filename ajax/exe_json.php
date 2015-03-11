<?php

	require ('../include/init.inc.php');
	$para=$_POST['para'];
	switch ($para['method']) {
		case 'insertSaleOutOrder':
			$data = Sale::insertSaleOutOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;
		case 'getPassedSaleOrder':
			$data = Sale::getPassedSaleOrder();
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
		case 'insertOsOrder':
			$data = Outsource::insertOsOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;	
		case 'insertOsOutOrder':
			$data = Outsource::insertOsOutOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;	
		case 'insertOsInOrder':
			$data = Outsource::insertOsInOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;
		case 'getAllOsOrderMst':
			$data = Outsource::getAllOsOrderMst();
			echo json_encode($data);
			break;
		case 'getPassedOsOrderMst':
			$data = Outsource::getPassedOsOrderMst();
			echo json_encode($data);
			break;
		case 'getOsOrderMstById':
			$data = Outsource::getOsOrderMstById($para['id']);
			echo json_encode($data);
			break;			
		case 'getOsOrderDtlById':
			$data = Outsource::getOsOrderDtlById($para['id']);
			echo json_encode($data);
			break;
		case 'getOsOutAllByOsOrderId':
			$data = Outsource::getOsOutAllByOsOrderId($para['id']);
			echo json_encode($data);
			break;
		case 'getOsStocks':
			$data = Outsource::getOsStocks($para['os_unit']);
			echo json_encode($data);
			break;
		case 'getOsTypes':
			$data = Outsource::getOsTypes();
			echo json_encode($data);
			break;
		case 'getOs_units':
			$data = Outsource::getOs_units();
			echo json_encode($data);
			break;
		case 'getSelect':
			$data = Baseinfo::getSelect($para['table']);
			echo json_encode($data);
			break;	
		case 'changePassword':
			$data = User::changePassword($para['old_password'],$para['new_password']);
			echo json_encode($data);
			break;	
		case 'getStocks':
			$data = Stock::getStocks($para['loc_id']);
			echo json_encode($data);
			break;	
		case 'insertPurchaseOrder':
			$data = Purchase::insertPurchaseOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;	
		case 'getAllPurchaseOrderMst':
			$data = Purchase::getAllPurchaseOrderMst();
			echo json_encode($data);
			break;
		case 'getPassedPurchaseOrder':
			$data = Purchase::getPassedPurchaseOrder();
			echo json_encode($data);
			break;
		case 'getPurchaseOrderMstById':
			$data = Purchase::getPurchaseOrderMstById($para['id']);
			echo json_encode($data);
			break;
		case 'getPurchaseOrderDtlById':
			$data = Purchase::getPurchaseOrderDtlById($para['id']);
			echo json_encode($data);
			break;
		case 'insertPurchaseInOrder':
			$data = Purchase::insertPurchaseInOrder($para['mst_data'],$para['dtl_data']);
			echo json_encode($data);
			break;
		case 'getPurchaseInAllByPurchaseOrderId':
			$data = Purchase::getPurchaseInAllByPurchaseOrderId($para['id']);
			echo json_encode($data);
			break;
		case 'getPrivilege':
			$data = Baseinfo::getPrivilege($para['group_id']);
			echo json_encode($data);
			break;
		case 'updatePrivilege':
			$data = Baseinfo::updatePrivilege($para['group_id'],$para['data']);
			echo json_encode($data);
			break;
		case 'getProducts':
			$data = Baseinfo::getProducts();
			echo json_encode($data);
			break;
		case 'getProductById':
			$data = Baseinfo::getProductById($para['id']);
			echo json_encode($data);
			break;
		case 'updateMinStock':
			$data = Baseinfo::updateMinStock($para['id'],$para['min_stock']);
			echo json_encode($data);
			break;
		case 'getCustTypes':
			$data = Sale::getCustTypes();
			echo json_encode($data);
			break;
		case 'getCustomers':
			$data = Sale::getCustomers();
			echo json_encode($data);
			break;
		case 'getSuppliers':
			$data = Purchase::getSuppliers();
			echo json_encode($data);
			break;
		case 'getStatus':
			$data = Baseinfo::getStatus();
			echo json_encode($data);
			break;
		case 'saveBom':
			$data = Baseinfo::saveBom($para['product_id'],$para['dtl_data']);
			echo json_encode($data);
			break;			
		case 'getSubpart':
			$data = Baseinfo::getSubpart($para['id']);
			echo json_encode($data);
			break;
		default:
			# code...
			break;
	}

?>	
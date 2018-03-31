<?php
	require ('../../../include/init.inc.php');

	$op=$_GET['op'];

	switch ($op) {		
		case 'Dtl':
			$mst_table=$_GET['mst_table'];
			Dtl($mst_table);
			break;
		case 'OsInDtl':
			$id=$_GET['id'];
			$datas=Outsource::getOsInDtlById($id);
			echo json_encode($datas);
			break;
		case 'WorkInMst':
			WorkInMst();
			break;
		case 'DrawOutMst':
			DrawOutMst();
			break;	
		case 'PurchaseInMst':
			PurchaseInMst();
			break;
		case 'SaleOutMst':
			SaleOutMst();
			break;
		case 'OsOutMst':
			OsOutMst();
			break;
		case 'OsInMst':
			OsInMst();
			break;
		case 'ProductMonthly':
			ProductMonthly();
			break;	
		default:
			# code...
			break;
	}
	function ProductMonthly(){
		$month=$_GET['month'];
		$product_id=$_GET['product_id'];
		$datas=Baseinfo::ProductMonthly($month,$product_id);
		echo json_encode($datas);
	}
	function WorkInMst(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$datas=Work::getWorkInMst(null,$date_start,$date_end);
		echo json_encode($datas);
	}

	function DrawOutMst(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$datas=Work::getDrawOutMst(null,$date_start,$date_end);
		echo json_encode($datas);
	}

	function PurchaseInMst(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$datas=Purchase::getPurchaseInMst(null,$date_start,$date_end);
		echo json_encode($datas);
	}

	function SaleOutMst(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$datas=Sale::getSaleOutList(null,$date_start,$date_end);
		echo json_encode($datas);
	}

	function OsOutMst(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$datas=Outsource::getOsOutMst(null,$date_start,$date_end);
		echo json_encode($datas);
	}

	function OsInMst(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$datas=Outsource::getOsInMst(null,$date_start,$date_end);
		echo json_encode($datas);
	}

	function Dtl($mst_table){
		$id=$_GET['id'];
		$datas=Baseinfo::getDtlById($id,$mst_table);
		echo json_encode($datas);
	}
?>
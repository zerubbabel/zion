<?php
	require ('../../../include/init.inc.php');
	
	$id=$_GET['id'];
	$datas=Purchase::getPurchaseOrderDtlById($id);
	echo json_encode($datas);
	
?>
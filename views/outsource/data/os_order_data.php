<?php
	require ('../../../include/init.inc.php');
	
	$id=$_GET['id'];
	$datas=Outsource::getOsOrderDtlById($id);
	echo json_encode($datas);
	
?>
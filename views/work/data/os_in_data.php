<?php
	require ('../../../include/init.inc.php');	
	$id=$_GET['id'];
	$datas=Outsource::getOsInDtlById($id);
	echo json_encode($datas);	
?>
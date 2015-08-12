<?php
	require ('../../../include/init.inc.php');
	
	$id=$_GET['id'];
	$datas=Work::getWorkInDtlById($id);
	echo json_encode($datas);
	
?>
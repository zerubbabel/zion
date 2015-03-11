<?php
	require ('../../../include/init.inc.php');
	
	$id=$_GET['id'];
	$datas=Work::getWorkDrawDtlById($id);
	echo json_encode($datas);
	
?>
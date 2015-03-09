<?php
	require ('../../include/init.inc.php');
	$id=$_GET['id'];
	$datas=Baseinfo::getSubpart($id);
	echo json_encode($datas);
?>
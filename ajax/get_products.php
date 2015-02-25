<?php
	require ('../include/init.inc.php');
	$datas = Baseinfo::getProducts();

	echo json_encode($datas);
	
?>
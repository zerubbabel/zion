<?php
	require ('../include/init.inc.php');
	$datas = Sale::getAllSaleOrderMst();
	echo json_encode($datas);
	
?>
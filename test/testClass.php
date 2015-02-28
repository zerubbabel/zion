<?php
	require ('../include/init.inc.php');
	$mst_data={'lco_id':1};
	$dtl_data=[{'product_id':'1','qty':10000},
	{'product_id':'2','qty':200000},
	{'product_id':'3','qty':10}];
	$id = Sale::insertSaleOutOrder($mst_data,$dtl_data);
	echo json_encode($id);			

?>
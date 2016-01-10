<?php
	require ('../include/init.inc.php');
	// load library
	require 'php-excel.class.php';
	$loc_id=$_GET['loc_id'];
	$product_id=$_GET['product_id'];
	$product_name=$_GET['product_name'];
	$bin=$_GET['bin'];

	// create a simple 2-dimensional array
	/*$data = array(
	        1 => array ('Name', 'Surname'),
	        array('Schwarz', 'Oliver'),
	        array('Test', 'Peter')
	        );*/
	$data = array(
	        1 => array ('产品代码', '产品名称','规格','库位','数量'),
	        );
	$result=Stock::viewStocks($loc_id,$product_id,$product_name,$bin);
	for ($i=0;$i<count($result);$i++){
		$data[]=array($result[$i]['product_id'],$result[$i]['name'],
			$result[$i]['gg'],$result[$i]['bin'],
			$result[$i]['qty']);
	}
	// generate file (constructor parameters are optional)
	$xls = new Excel_XML('UTF-8', false,'sheet1');
	$xls->addArray($data);
	$xls->generateXML('stock');

?>
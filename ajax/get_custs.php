<?php
	/*$datas=array( 
		array("id"=>"1","name"=>"Desktop Computer","note"=>"note","stock"=>"Yes","ship"=>"FedEx","sdate"=>"2007-12-03"),
		array("id"=>"2","name"=>"Laptop","note"=>"Long text ","stock"=>"Yes","ship"=>"InTime","sdate"=>"2007-12-03"));
	*/
	require ('../include/init.inc.php');

	//$datas = $database->select("customers","*");
	$datas = Baseinfo::getCusts();
	echo json_encode($datas);
	
?>
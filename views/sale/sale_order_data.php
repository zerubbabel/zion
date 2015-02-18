<?php
	$oper=$_GET['q'];

	switch ($oper) {
		case 'dtl':
			get_dtl();
			break;
		
		default:
			# code...
			break;
	}

	function get_dtl(){
		$id=$_GET['id'];
		require_once '../../config.php';
		require_once '../../include/medoo.min.php';
		$database = new medoo($db_path);
		$datas = $database->select("sale_order_dtl",
		["[>]products"=>["product_id"=>"id"]],
		["product_name","qty"],
		["mst_id"=>$id]);
		//var_dump($database->error());
		echo json_encode($datas);
	}
	
	
	
	 
	
	
	

	
?>
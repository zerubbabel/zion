<?php
	require ('../../../include/init.inc.php');

	$oper=$_POST['oper'];
	switch ($oper) {
		case 'edit':
			edit();
			break;
		case 'add':
			//add();
			break;
		case 'del':
			//stop();
			break;
		default:
			break;
	}

function edit(){
	if(isset($_POST['bin'])){
		$bin=$_POST['bin'];
		$product_id=$_POST['id'];	
		$result=Stock::updateStockBin($product_id,$bin);
		echo json_encode($result); 
	}
}
	
?>
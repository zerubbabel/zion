<?php
	require ('../../../include/init.inc.php');

	$oper=$_POST['oper'];
	switch ($oper) {
		case 'edit':
			edit();
			break;
		case 'add':
			add();
			break;
		case 'del':
			stop();
			break;
		default:
			break;
	}
/*	
function stop(){//状态status改为0，停用
	$id=$_POST['id'];	
	$table='products';
	$where=array('id'=>$id);
	$data=array('status'=>0);
	$result=Db::updateRecord($table,$data,$where);	
	echo json_encode($result); 
}
*/
function edit(){
	$id=$_POST['id'];
	$product_name=$_POST['name'];
	$product_id=$_POST['product_id'];
	$gg=$_POST['gg'];
	$min_stock=$_POST['min_stock'];
	$table='products';
	$where=array('id'=>$id);
	$data=array('product_name'=>$product_name,'product_id'=>$product_id,
		'gg'=>$gg,'min_stock'=>$min_stock);
	$result=Db::updateRecord($table,$data,$where);
	echo json_encode($result); 
}
function add()	{
	$product_name=$_POST['name'];	
	$product_id=$_POST['product_id'];
	$gg=$_POST['gg'];
	$min_stock=$_POST['min_stock'];
	$table='products';
	$data=array('product_name'=>$product_name,'product_id'=>$product_id,
		'gg'=>$gg,'min_stock'=>$min_stock);
	$result=Db::insertRecord($table,$data);	
	echo json_encode($result); 
}
	
?>
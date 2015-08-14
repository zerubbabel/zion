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
			del();
			break;
		default:
			break;
	}

function edit(){	
	$id=$_POST['id'];
	$loc=$_POST['loc_name'];
	$bin_name=$_POST['name'];
	$table='location_bin';
	$where=array('id'=>$id);
	$data=array('bin'=>$bin_name,'loc_id'=>$loc);
	$result=Db::updateRecord($table,$data,$where);
	echo json_encode($result); 	
}

function add()	{
	$loc=$_POST['loc_name'];
	$bin_name=$_POST['name'];
	$data=array('bin'=>$bin_name,'loc_id'=>$loc);
	$result=Stock::insertBin($data);	
	echo json_encode($result); 
}	
function del(){	
	$id=$_POST['id'];
	//$table='location_bin';
	//$where=array('id'=>$id);
	$result=Stock::deleteBin($id);
	echo json_encode($result); 	
}
?>
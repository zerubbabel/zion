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
			//stop();
			break;
		default:
			break;
	}

function edit(){	
	$id=$_POST['id'];
	$loc=$_POST['loc_name'];
	$bin_name=$_POST['name'];
	$table='location_bin';
	$where=array('bin'=>$bin_name,'loc_id'=>$loc);
	$result=Db::updateRecord($table,$data,$where);
	echo json_encode($result); 	
}

function add()	{
	$loc=$_POST['loc_name'];
	$bin_name=$_POST['name'];
	$table='location_bin';
	$data=array('bin'=>$bin_name,'loc_id'=>$loc);
	$result=Db::insertRecord($table,$data);	
	echo json_encode($result); 
}	
?>
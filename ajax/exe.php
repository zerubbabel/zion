<?php
	require ('../include/init.inc.php');
	$type=$_POST['type'];
	$table=$_POST['table'];
	$cols=$_POST['cols'];
	$data=$_POST['data'];
	echo json_encode(exe($type,$table,$cols,$data));

	
	function exe($type,$table,$cols,$data){	
		switch ($type) {
			case 'insertMst':	
				$id = Db::insertMst($table,$cols,$data);
				return $id;					
				break;
			case 'insertDtl':						
				$id = Db::insertDtl($table,$cols,$data);
				return $id;	
				break;

			default:
				# code...
				break;
		}	
	}		
?>
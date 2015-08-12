<?php
	require ('../../../include/init.inc.php');	
	$report_type=$_GET['report_type'];
	switch ($report_type) {
		case 'work_in':
			loadWorkIn();
			break;
		
		default:
			# code...
			break;
	}

	function loadWorkIn(){
		$date_start=$_GET['date_start'];
		$date_end=$_GET['date_end'];
		$data = Work::getWorkInMst($date_start,$date_end);
		echo json_encode($data);
	}
	
		
?>
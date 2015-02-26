<?php
	require ('./include/init.inc.php');

	$location=$_GET['location'];
	$url=substr($location,6);
	
	$user_id=$_SESSION['user_info']['user_id'];
	
	$datas=User::getAccess($user_id,$url);

	if (count($datas)>0){
		$json = array ('status'=>true,'page_name'=>$datas[0]['page_name']);
	}else{
		$json = array ('status'=>false);
	}
	echo json_encode($json);

?>
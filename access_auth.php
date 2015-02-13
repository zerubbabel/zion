<?php
	require_once 'config.php';
	require_once 'include/medoo.min.php';
	 
	$database = new medoo($db_path);//($DB_NAME);

	$location=$_GET['location'];
	$url=substr($location,6);
	session_start();
	$user=$_SESSION['user_id'];
	$datas = $database->select("access", [
		"[>]users"=>["group_id"=>"group"],
		"[>]pages"=>["page_id"=>"id"],
		],
		"*",
		["AND"=>[
		"pages.url"=>$url,
		"users.user_id"=>$user
		]]);
	//var_dump($datas);
	//var_dump($database->error());

	if (count($datas)>0){
		$json = array ('status'=>true);
	}else{
		$json = array ('status'=>false);
	}
	echo json_encode($json);

?>
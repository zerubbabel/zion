<?php
	// 示例：
	require_once 'config.php';
	require_once 'include/medoo.min.php';
	 
	$database = new medoo($DB_NAME);
	//print_r($database->info());
	//var_dump($database);
	$datas = $database->select("users", "*",["AND"=>["password"=>'1223',"user_name"=>'hcy']]);
	var_dump($datas);
	var_dump(count($datas));
	var_dump($database->error());
?>
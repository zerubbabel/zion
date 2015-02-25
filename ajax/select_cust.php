<?php
	include '../config.php';	
	include '../init.php';	
	
	var_dump($db_path);
	$database = new medoo($db_path);
	var_dump($database);
	$datas = $database->select("customers","*");
	echo '<select id="cust">';
	for ($i=0;$i<count($datas);$i++){
		echo '<option value="' . $datas[$i]['id'] .'">' . $datas[$i]['cust_name']  . '</option>';
	}
	echo '</select>';	
?>
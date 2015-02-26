<?php
	require ('../include/init.inc.php');
	$type=$_GET['type'];
	switch ($type) {
		case 'cust':
			echo cust();
			break;
		
		default:
			# code...
			break;
	}
function cust(){
	$datas = Baseinfo::getCusts();
	$str='<select id="cust">';
	for ($i=0;$i<count($datas);$i++){
		$str.='<option value="' . $datas[$i]['id'] .'">' . $datas[$i]['cust_name']  . '</option>';
	}
	$str.='</select>';
	return $str;
}	
	
		
?>
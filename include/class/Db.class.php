<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Db extends Base {

	//列表 
	public static function insertMst($table,$cols,$data){
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();		
		$d=array();
		for ($i=0;$i<count($cols);$i++){
			$d[$cols[$i]]=$data[$i];
		}		
		$createday=date('Y-n-j G:i:s');		
		$op_id=$_SESSION['user_info']['user_id'];
		$d['createday']=$createday;
		$d['op_id']=$op_id;
		$id = $db->insert ($table, $d);
		if ($id) {
			return $id;
		}else{
			return $db->error();
			return false;
		}
	}

	public static function insertDtl($table,$cols,$data){
		if (! $data || ! is_array ( $data )) {
			return false;
		}
		$db=self::__instance();		
		$d=array();
		for ($i=0;$i<count($cols);$i++){
			$d[$cols[$i]]=$data[$i];
		}		
		$id = $db->insert ($table, $d);
		if ($id) {
			return $id;
		}else{
			return $db->error();
			return false;
		}
	}

}

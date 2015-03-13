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
		$createday=date('Y-m-d H:i:s');		
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

	public static function updateRecord($table,$data,$where){
		$db=self::__instance();
		$result=$db->update($table,$data,$where);
		if($result){
			return array('status'=>true,'msg'=>'操作成功！');
		}
		return array('status'=>false,'msg'=>$db->error()[2]);//'操作失败！');
	}

	public static function insertRecord($table,$data){
		$db=self::__instance();
		$result=$db->insert($table,$data);
		if($result){
			return array('status'=>true,'msg'=>'操作成功！');
		}
		return array('status'=>false,'msg'=>'操作失败！');
	}
}

<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Test extends Base {

	//列表 
	public static function getUsers() {
		$db=self::__instance();
		$sql="select * from users";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
}

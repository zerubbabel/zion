<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Baseinfo extends Base {
	//列表 
	public static function getCusts() {
		$db=self::__instance();
		$sql="select * from customers";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}

	public static function getproducts() {
		$db=self::__instance();
		$sql="select id,product_name as name from products";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
}

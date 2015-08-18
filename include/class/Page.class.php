<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Page extends Base {
	//列表 
	public static function getPages() {
		$db=self::__instance();
		$sql="select * from pages 
			left join modules on pages.module_id=modules.module_id 
			where stop=1 
			order by module_id";
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
	
	
}

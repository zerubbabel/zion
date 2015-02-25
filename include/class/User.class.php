<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class User extends Base{
	// 表名
	private static $table_name = 'users';
	// 查询字段
	private static $columns = 'user_id, user_name, password, user_group,status';
	
	public static function logout(){
		setcookie("app_remember","",time()-3600);
		unset($_SESSION[UserSession::SESSION_NAME]);
	}
	
	public static function checkPassword($user_name, $password) {
		$md5_pwd = $password;//md5 ( $password );
		$db=self::__instance();	
		$condition = array("AND"=>
						array("user_name" => $user_name,
							"password" => $md5_pwd,
						)
					);			
		$list = $db->select( self::$table_name, self::$columns, $condition );	

		if ($list) {			
			return $list [0];
		} else {
			return false;
		}
	}
	
	public static function loginDoSomething($user_id){
		
		$user_info = User::getUserById($user_id);
		if($user_info['status']!=1){
			Common::jumpUrl("login.php");
			return;
		}
		UserSession::setSessionInfo($user_info);
	}
	
	public static function getUserById($user_id) {
		if (! $user_id || ! is_numeric ( $user_id )) {
			return false;
		}
		$db=self::__instance();
		$condition = array("AND" => 
						array("user_id[=]" => $user_id,
						)
					);
		$list = $db->select ( self::$table_name, self::$columns, $condition );		
		if ($list) {
			return $list [0];
		}
		return array ();
	}
	
	public static function getAccess($user_id,$url) {
		$db=self::__instance();
		$sql="select * from access 
			left join users on access.group_id=users.user_group  
			left join pages on access.page_id=pages.id  
			where pages.url='".$url."' and users.user_id=".$user_id;
		
		$list = $db->query($sql)->fetchAll();
		if ($list) {			
			return $list;
		}
		return array ();
	}
}
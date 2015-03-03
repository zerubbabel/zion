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

	
	public static function updatePassword($user_id,$new_password) {
		$db=self::__instance();
		$data=array('password'=>$new_password);
		$where=array('user_id'=>$user_id);
		$id=$db->update('users',$data,$where);
		if($id){
			return array('status'=>true);
		}else{
			return array('status'=>false,'msg'=>$db->error());
		}
		
	}

	public static function changePassword($old_password,$new_password) {
		$db=self::__instance();
		$user_name=$_SESSION['user_info']['user_name'];
		$user_id=$_SESSION['user_info']['user_id'];
		$ans=array();
		$result=User::checkPassword($user_name,$old_password);
		if($result){
			$result=User::updatePassword($user_id,$new_password);
			if ($result && $result['status']){
				$ans['status']=true;
				$ans['msg']='操作成功!';
			}else{
				$ans['status']=false;
				$ans['msg']='修改密码失败!';
			}
		}
		else{
			$ans['status']=false;
			$ans['msg']='原密码错误！';	
		}		
		return $ans;
	}
}
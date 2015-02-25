<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class UserSession{
	const SESSION_NAME="user_info";
	public static function setSessionInfo($user_info){
		$_SESSION[self::SESSION_NAME] = $user_info;
		return true;
	}
}
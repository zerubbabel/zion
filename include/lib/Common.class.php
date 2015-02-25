<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Common {

	public static function jumpUrl($url) {
		
		Header ( "Location: ".APP_URL."/$url" );
		return true;
	}
}
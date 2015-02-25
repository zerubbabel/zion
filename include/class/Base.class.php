<?php
//if(!defined('ACCESS')) {exit('Access denied.');}
class Base {
	protected static $table_prefix = '';
	protected static $db_container = array();
	public static function __instance($database=DB_NAME){
		if( @self::$db_container[$database]  == null ){
			self::$db_container[$database] = new Medoo( $database );
			return self::$db_container[$database];
		}
		return self::$db_container[$database];
	}
}

<?php
//define ('ACCESS',1); 
error_reporting(E_ALL ^ E_NOTICE);
//autoload 使用常量
define ( 'APP_ROOT', dirname ( __FILE__ ) . '/../../' );
define ( 'APP_BASE', dirname ( __FILE__ ) . '/../../include' );
define ( 'APP_BASE_LIB', APP_BASE . '/lib/' );
define ( 'APP_BASE_CLASS', APP_BASE . '/class/' );

//App常量
define ( 'APP_URL' ,'http://localhost/acezion/zion');
define ( 'APP_TITLE' ,'锡安卫浴企业管理平台');
define ( 'COMPANY_NAME' ,'锡安卫浴');

//数据库设置
$db_path=APP_ROOT.'/zion.db';
define ( 'DB_NAME' ,$db_path);

?>
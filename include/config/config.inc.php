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
define ( 'AUTHOR_NAME' ,'HCY');
define ( 'VERSION' ,'1.01');
define ( 'REPORT_DAYS' ,3);//默认报表查看时间
//数据库设置
$db_path=APP_ROOT.'/zion.db';
define ( 'DB_NAME' ,$db_path);

//订单状态
define ( 'ORDER_COMPLETE' ,0);
define ( 'ORDER_NORMAL' ,1);
define ( 'ORDER_APPROVED' ,2);//验证通过
define ( 'ORDER_DENY' ,3);//验证未通过
?>
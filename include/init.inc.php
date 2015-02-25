<?php
error_reporting( E_ALL );
require 'config/config.inc.php';
session_start();
function AppAutoLoad($classname){
	$filename = str_replace('_', '/', $classname) . '.class.php';
    // class类
    $filepath = APP_BASE_CLASS . $filename;
    if (file_exists($filepath)) {
        return include $filepath;
    }else{
		//仅对Class仅支持一级子目录
		//如果子目录中class文件与CLASS根下文件同名，则子目录里的class文件将被忽略

		$handle=opendir(APP_BASE_CLASS);
		
		while (false !== ($file = readdir($handle))) {
			if (is_dir(APP_BASE_CLASS. "/" . $file)) {
				$filepath=APP_BASE_CLASS."/".$file."/".$filename;
				if (file_exists($filepath)) {
					return include $filepath;
				}
			}
		}
	}
    //lib库文件
    $filepath = APP_BASE_LIB . $filename;
    if (file_exists($filepath)) {
        return include $filepath;
    }

    throw new Exception( $filepath . ' NOT FOUND!');
}
spl_autoload_register('AppAutoLoad');

?>
<?php
require ('./include/init.inc.php');
User::logout();
//location首部使浏览器重定向到另一个页面
$home_url = 'login.php';
Common::jumpUrl ( $home_url );
?>
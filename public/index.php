<?php
define('APPLICATION_PATH', str_replace(['/public','\public'],'',dirname(__FILE__)));
ini_set('date.timezone','Asia/Shanghai');
date_default_timezone_set('Asia/Shanghai');
$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");
require "../vendor/autoload.php";
$application->bootstrap()->run();
//?>

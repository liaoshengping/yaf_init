<?php

define('APPLICATION_PATH', dirname(__FILE__));

$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");
require_once(APPLICATION_PATH."/vendor/autoload.php");
$application->bootstrap()->run();
?>

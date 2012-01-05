<?php
/* this is single entry file */
//加载autoload
include "../simple/autoload.php";
$Simple_Autoload = new Simple_Autoload();
//加载config
$app_home = dirname(__FILE__)."/../app";
//加载application
$Simple_Application = new Simple_Application($app_home, $app_home."/config.php");
$Simple_Application->run();

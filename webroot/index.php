<?php
/* this is single entry file */
include "../simple/autoload.php";
Simple_Autoload::getInstance();
$app_home = dirname(__FILE__)."/../app";
$Simple_Application = new Simple_Application($app_home, $app_home."/config.php");
$Simple_Application->run();

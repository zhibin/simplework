<?php
$config = Simple_Config::getInstance();
$config->setGlobalOption("app_home", "D:/project/php/simplework/app");
$config->setGlobalLoader("Work_Router_Regex");
$config->setGlobalLoader("Work_Db_Zend");
$config->setGlobalOption("router_url", "Simple_Router");
$config->setGlobalOption("home_page",  array("index" , "index" , "index"));
$config->setMainApplication("index");
$config->setOption("error_page", array("app"=>"index" , "controller"=>"index" , "action"=>"error"));
$config->setIncludePath("d:\\project\\123");
$config->setIncludePath("d:\\project\\123");
$config->setPhpSetting("display_errors", 1);
$config->setPhpSetting("zlib.output_compression", "ON");
$config->setOption("app_path", "D:/project/php/simplework/app");
$config->setOption("debug", 1);
$config->addChildApplication("ccc");
$config->setIncludePath("d:\\project\\php");
$config->setOption("debug", 0);
$config->setPhpSetting("display_errors", 0);
?>

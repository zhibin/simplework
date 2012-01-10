<?php
include "../Simple/Application.php";
define(APP_HOME, dirname(__FILE__)."/../app") ;
Simple_Application::getInstance(APP_HOME)
->setConfig(APP_HOME."/system/config.php")
->boot()
->run();

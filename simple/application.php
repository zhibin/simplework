<?php
/* this file is start application */
class Simple_Application
{
    private $config;
    public function __construct($app_home, $file)
    {
        $Simple_Config = Simple_Config::getInstance($app_home);
        $Simple_Config->setGlobalConfigFile($file);
        $this->config = $Simple_Config;
    }
    public function run($child = '')
    {
        $this->config->complic();
        $this->config->setPhpSettings('global');
        $this->config->setIncludePaths('global');
        Simple_Registry::set("config", $this->config);
        if (! empty($child) && in_array($child, $this->config->application)) {
            $this->config->setPhpSettings($child);
            $this->config->setIncludePaths($child);
        }
        try {
            $this->config->loader();
            Simple_Front::getInstance()->run();
        } catch (Simple_Exception $e) {
            echo $e->getTraceAsString();
            echo "\r\n";
        }
    }
}

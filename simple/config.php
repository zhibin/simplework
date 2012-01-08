<?php
class Simple_Config
{
    public static $instance;
    public $mainApplication = "default";
    public $currentApplication = "default";
    public $application = array("default");
    public $options = array();
    public $loader = array();
    public $includePaths = array();
    public $phpSettings = array();
    private function __construct()
    {}
    static public function getInstance($path = "")
    {
        if (empty(self::$instance)) {
            self::$instance = new self($path);
            self::$instance->setOption("app_home", $path);
            self::$instance->initDefaultConfig();
        }
        return self::$instance;
    }
    public function setMainApplication($mainApplication)
    {
        if (empty($mainApplication) && ! is_string($mainApplication)) {
            throw new Simple_Excetpion("application name not empty");
        }
        if ($mainApplication != $this->mainApplication) {
            $this->options[$mainApplication] = $this->options[$this->mainApplication];
            unset($this->options[$this->mainApplication]);
            $this->includePaths[$mainApplication] = $this->options[$this->mainApplication];
            unset($this->includePaths[$this->mainApplication]);
            $this->phpSettings[$mainApplication] = $this->options[$this->mainApplication];
            unset($this->phpSettings[$this->mainApplication]);
            $this->mainApplication = $mainApplication;
            $this->currentApplication = $mainApplication;
            $this->application[0] = $mainApplication;
        }
    }
    public function addChildApplication($childApplication)
    {
        if (empty($childApplication) && ! is_string($childApplication)) {
            throw new Simple_Excetpion("application name not empty");
        }
        $this->currentApplication = $childApplication;
        $this->application[] = $childApplication;
        $this->options[$childApplication] = array();
    }
    public function getGlobalLoader($key)
    {
        return $this->loader['global'][$key];
    }
    public function setGlobalLoader($value)
    {
        $this->loader['global'][] = $value;
    }
    public function loader()
    {
        if (! empty($this->loader))
            foreach ($this->loader['global'] as $k => $v) {
               Simple_Registry::loader($v);
            }
    }
    public function getLoader($app, $key)
    {
        return $this->loader[$app][$key];
    }
    public function setLoader($value)
    {
        $this->loader[$this->currentApplication][] = $value;
    }
    public function getGlobalOption($key)
    {
        return $this->options['global'][$key];
    }
    public function getOption($app, $key)
    {
        return $this->options[$app][$key];
    }
    public function setGlobalOption($key, $value)
    {
        $this->options['global'][$key] = $value;
    }
    public function setOption($key, $value)
    {
        $this->options[$this->currentApplication][$key] = $value;
    }
    public function setGlobalIncludePath($value)
    {
        $this->includePaths['global'][] = $value;
    }
    public function setIncludePath($value)
    {
        $this->includePaths[$this->currentApplication][] = $value;
    }
    public function setGlobalPhpSetting($key, $value)
    {
        $this->phpSettings['global'][$key] = $value;
    }
    public function setPhpSetting($key, $value)
    {
        $this->phpSettings[$this->currentApplication][$key] = $value;
    }
    public function setIncludePaths($child)
    {
        if (! empty($this->includePaths[$child])) {
            $path = implode(PATH_SEPARATOR, $this->includePaths[$child]);
            set_include_path($path . PATH_SEPARATOR . get_include_path());
        }
    }
    public function setPhpSettings($child)
    {
        if (! empty($this->phpSettings[$child])) {
            foreach ($this->phpSettings[$child] as $k => $v) {
                ini_set($k, $v);
            }
        }
    }
    public function setGlobalConfigFile($file)
    {
        $this->setGlobalOption("config_path", $file);
        include $file;
    }
    public function setUserConfigFile($file)
    {
        if (empty($this->options[$this->currentApplication]['config_path'])) {
            $this->setOption("config_path", $file);
            include $file;
        } else {
            throw new Simple_Expection("config_path seted value");
        }
    }
    public function initDefaultConfig()
    {
        $this->setGlobalOption("domain", "localhost");
        $this->setGlobalOption("db_config",
               array(
               		 "master"=>array("db_host"=>"localhost",
               						"db_user"=> "root",
                                    "db_pass"=> "", 
                                    "db_port"=> "",
                                    "db_name"=> "test",
                                    "db_charset"=>"utf-8",
                                    "db_percent" =>""),
               
                    "slave0"=>array("db_host"=>"localhost",
               						"db_user"=> "root",
                                    "db_pass"=> "", 
                                    "db_port"=> "",
                                    "db_name"=> "test",
                                    "db_charset"=>"utf-8",
                                    "db_percent" =>70),
               
                    "slave1"=>array("db_host"=>"localhost",
               						"db_user"=> "root",
                                    "db_pass"=> "", 
                                    "db_port"=> "",
                                    "db_name"=> "test",
                                    "db_charset"=>"utf-8",
                                    "db_percent" =>30)
               )
               
         );
        $this->setGlobalOption("db_type","mysqli");//{mysqli,mysqlp,mysqls}
        $this->setGlobalOption("db_host", "localhost");
        $this->setGlobalOption("db_user", "root");
        $this->setGlobalOption("db_pass", "");
        $this->setGlobalOption("db_port", "");
        $this->setGlobalOption("db_name", "");
        $this->setGlobalOption("error_page", array("app"=>"error" , "controller"=>"error" , "action"=>"error"));
        $this->setGlobalOption("controller_prefix","");
        $this->setGlobalOption("controller_suffix", "controller");
        $this->setGlobalOption("action_prefix","");
        $this->setGlobalOption("action_suffix", "action");
        
        
        $this->setGlobalIncludePath("");
        $this->setGlobalPhpSetting("", "");
    }
    public function complic()
    {
        foreach ($this->application as $k => $v) {
            $this->options[$v] = array_merge($this->options['global'], $this->options[$v]);
        }
    }
}

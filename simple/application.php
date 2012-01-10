<?php
class Simple_Application
{
    public static $instance;
    public $app_home;
    public $config_file;
    private function __construct($app_home)
    {
       $this->app_home = $app_home;
    }
    public static function getInstance($app_home)
    {
        if(!self::$instance)
        {
           self::$instance = new self($app_home); 
        }
        return self::$instance;
    }
    public function setConfig($config_file)
    {
        $this->config_file = $config_file;
        return $this;
    }
    public function boot()
    {
        
        //set name space
        set_include_path(get_include_path().PATH_SEPARATOR .dirname(__FILE__).'/../');
        require_once 'Zend/Loader/Autoloader.php';
		$zend_loader = Zend_Loader_Autoloader::getInstance();
		$zend_loader->registerNamespace('Simple_');
		
		//boot config
		if(!file_exists($this->config_file))
		{
		    throw new Simple_Exception($this->config_file."not find");
		}
		$zend_config = new Zend_Config(require $this->config_file , true);
		//set user autoload file
		$autoload_path = $this->app_home.'/'.$zend_config->autoload_file;
        if(!file_exists($autoload_path))
		{
			$autoload_dirs = $zend_config->autoload_dirs;
			if(!empty($autoload_dirs))
			foreach($autoload_dirs as $dir)
			{	
				$include_dirs[] = $this->app_home.'/'.$dir;
			}
			$generator = new Simple_Tool_Assembly($autoload_path, $include_dirs);
			$generator->generate();
		}
		include $autoload_path;
		$zend_loader->pushAutoloader('simple_autoload');
		
		
		//load user config
		$zend_config->app_home = $this->app_home;
		Zend_Registry::set("config", $zend_config);
		
		return $this;
    }
    public function check()
    {
        $config = Zend_Registry::get("config");
		
        if(empty($config->error_page) || empty($config->home_page))
        {
            throw  new Simple_Exception("config error_page , home_page mast!");
        }
    }
    public function run()
    {
        
     
        
        try{
            $this->check();
            Simple_Front::getInstance()->run();
        }catch (Exception $e)
        {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
    }
}

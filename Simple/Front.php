<?php
class Simple_Front
{
    public $request;
    public $response;
    public $rewrite;
    public $dispatch;
    public $plugins;
    public static $instance;
    private function __construct()
    {}
    static public function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->request = new Simple_Request();
            self::$instance->rewrite = new Simple_Rewrite(self::$instance->request);
            self::$instance->response = new Simple_Response();
            self::$instance->dispatch = new Simple_Dispatch(self::$instance->request, self::$instance->response, self::$instance->rewrite);
        }
        return self::$instance;
    }
    public function loaderPlugin()
    {
        $config = Zend_Registry::get("config");
        $plugin_dir = $config->plugin_dir;
        $plguin_path = $config->app_home."/".$plugin_dir;
        if(!empty($plguin_path))
        {
            if (! is_dir($plguin_path)) 
            {
                throw new Simple_Exception("$plugin_path not find ");
            }
            $plugin_list = $this->searchPlugin($plguin_path, '/^(.*)?\.plugin\.php/');
            if(!empty($plugin_list))
            {
                foreach($plugin_list as $k => $v)
                {
                    $plugin_class = ucfirst($v['class'])."Plugin";
                    if(!class_exists($plugin_class))
                    {
                        include_once $v['file'];
                    }
                    if(!class_exists($plugin_class))
                    {
                        throw new Simple_Exception("$plugin_class not find");
                    }
                    $plguin =  new $plugin_class($this->request, $this->response, $this->rewrite);
                    if(!$plguin instanceof Simple_Plugin )
                    {
                        throw new Simple_Exception("must expend Simple_Plugin");
                    }
                    $this->plugins[] = $plguin;
                }
            }
        }
    }
    public function searchPlugin($path, $pattern = "") 
    {
        $filelist = array();
        foreach (scandir($path) as $file) 
        {
            if ($file == '.' || $file == '..')
                continue;

            $dir_file = "$path/$file";
            if (is_dir($dir_file)) 
            {
                $filelist = array_merge($filelist, $this->searchPlugin($dir_file));
                continue;
            }
             if(empty($pattern) || preg_match($pattern,$file,$match))  
             {  
                  $filelist[]= array('file' => $dir_file, 'class'=>$match[1]);
             }
        }
        return $filelist;
    }
    public function routeStartup()
    {
        if(!empty($this->plugins))
        {
            foreach($this->plugins as $k => $v)
            {
                $v->routeStartup();
            }
        }
    }
    public function routeShutdown($map)
    {
        if(!empty($this->plugins))
        {
            foreach($this->plugins as $k => $v)
            {
                $v->routeShutdown($map);
            }
        }
    }
    public function dispatchLoopStartup($map)
    {
        if(!empty($this->plugins))
        {
            foreach($this->plugins as $k => $v)
            {
                $v->dispatchLoopStartup($map);
            }
        }
    }
    public function preDispatch($map)
    {
        if(!empty($this->plugins))
        {
            foreach($this->plugins as $k => $v)
            {
                $v->preDispatch($map);
            }
        }
    }
    public function postDispatch($map)
    {
        if(!empty($this->plugins))
        {
            foreach($this->plugins as $k => $v)
            {
                $v->postDispatch($map);
            }
        }
    }
    public function dispatchLoopShutdown($map)
    {
        if(!empty($this->plugins))
        {
            foreach($this->plugins as $k => $v)
            {
                $v->dispatchLoopShutdown($map);
            }
        }
    }
    public function run()
    {
        try {
            $this->loaderPlugin();
            ob_start();
            $this->dispatch->start($this);
        } catch (Simple_Exception $e) {
            echo $e->getMessage();
            echo $e->getTraceAsString();
        }
    }
}

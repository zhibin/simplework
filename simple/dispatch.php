<?php
class Simple_Dispatch
{
    public $request;
    public $response;
    public $rewrite;
    public function __construct($request, $response, $rewrite)
    {
        $this->request = $request;
        $this->response = $response;
        $this->rewrite = $rewrite;
    }
    public function start()
    {
        $this->response->getDispatch($this);
        $this->rewrite->analysis();
        $result = $this->rewrite->getResult();
        ob_start();
        $this->app($result);
    }
    public function app($result)
    {
        $result = $this->arraytolower($result);
        $this->response->clear();
         
        if(empty($result['app']) || empty($result['controller']) || empty($result['action']))
        {
            throw new Simple_Exception("empty!");
        }
        $config = Zend_Registry::get("config");
        
        $app_home = $config->app_home;
        $app_path = $this->formatAppToFile($app_home, $result['app']);
        $error_page = $config->error_page;
        if (! is_dir($app_path)) 
        {
            $app_path = $this->formatAppToFile($app_home, $error_page->app);
            
             if (! is_dir($app_path)) 
             {
                 throw new Simple_Exception("error_page app not fand!");
             }
             $result = $error_page->toArray();
        }
        $controller_path = $this->formatControllerToFile($app_path, $result['controller']);
        if (! file_exists($controller_path)) 
        {
            
           
            if($error_page->app == $result['app'] && $error_page->controller == $result['controller'])
            {
                 throw new Simple_Exception("error_page controller file  not fand!");
            }
            else if($config_app->$result['app']->error_page->app == $result['app'] && $config_app->$result['app']->error_page->controller == $result['controller'])
            {
                throw new Simple_Exception("{$result['app']} error_page  controller file  not fand!");
            }
            else 
            {
            	$config_app = $config->app;
            	if(empty($config_app->$result['app']->error_page))
            	{
            	    $this->app($error_page->toArray());
            	}
            	else 
            	{
            	    $this->app($config_app->$result['app']->error_page->toArray());
            	}
            	exit;
            }
            
        }
        $config_app = $config->app;
        $controllerClass = $this->formatControllerToClass($result['controller']);
        if (! class_exists($controllerClass)) {
            include_once $controller_path;
        }
        if (! class_exists($controllerClass)) 
        {
            if($error_page->app == $result['app'] && $error_page->controller == $result['controller'])
            {
                 throw new Simple_Exception("error_page controller class not fand!");
            }
            else if($config_app->$result['app']->error_page->app == $result['app'] && $config_app->$result['app']->error_page->controller == $result['controller'])
            {
                throw new Simple_Exception("{$result['app']} error_page controller class not fand!");
            }
            else 
            {
            	
            	if(empty($config_app->$result['app']->error_page))
            	{
            	    $this->app($error_page->toArray());
            	}
            	else 
            	{
            	    $this->app($config_app->$result['app']->error_page->toArray());
            	}
            	exit;
            }
        }
   
        $controller = new $controllerClass($result, $this->request, $this->response);
        $actionClass = $this->formatActionToClass($result['action']);
        
        if(!method_exists($controller,$actionClass ))
        {
            
            if($error_page->app == $result['app'] 
               && $error_page->controller == $result['controller']
               && $error_page->action == $result['action'])
            {
                 throw new Simple_Exception("error_page action not fand!");
            }
            else if($config_app->$result['app']->error_page->app == $result['app'] 
                    && $config_app->$result['app']->error_page->controller == $result['controller']
                    && $config_app->$result['app']->error_page->action == $result['action']
                        )
            {
                throw new Simple_Exception("{$result['app']} error_page action not fand!");
            }
            else 
            {
            	if(empty($config_app->$result['app']->error_page))
            	{
            	    $this->app($error_page->toArray());
            	}
            	else 
            	{
            	    $this->app($config_app->$result['app']->error_page->toArray());
            	}
            	exit;
            }
        }
        
        
        
        $controller->$actionClass();
        $controller->end();
        $this->response->sendHeader();
        $view = $this->response->render($result);
        return $view;
    }
    public function arraytolower($result)
    {
        foreach ($result as $k => $v) {
            $arr[$k] = strtolower($v);
        }
        return $arr;
    }
    public function formatAppToFile($path, $app)
    {
         return $path."/".$app;
    }
    public function formatControllerToFile($path,$controller)
    {
        return $path."/controller/".$controller . ".controller.php";
    }
    public function formatAppToClass($app)
    {
        return $result['app'];
    }
    public function formatControllerToClass($controller)
    {
        return ucfirst($controller) . "Controller";
    }
    public function formatActionToClass($action)
    {
        return ucfirst($action) . "Action";
    }

}

<?php
class Simple_Dispatch
{
    public $request;
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
        $this->app($result);
    }
    public function app($result)
    {
        $result = $this->arraytolower($result);
        $this->response->clear();
        try{
            $result = $this->validApp($result);
        }catch (Simple_Exception $e) {
            try{
                $config = Simple_Registry::get("config");
                $result = $config->getGlobalOption("error_page"); 
                $result = $this->validApp($result);
            }catch (Simple_Exception $e)
            {
                 throw new Simple_Exception("error not find ");
            }
        }
        try{
            $result = $this->validController($result);
        }
        catch (Simple_Exception $e){
             $config = Simple_Registry::get("config");
             $error_page = $config->getOption($result['app'], "error_page"); 
             $global_error_page =  $config->getGlobalOption("error_page"); 
             if(!$this->diff($result, $global_error_page) ){
                 throw new Simple_Exception("1error not find ");
             }
             else if($this->diff($result, $error_page)){
                 $this->app($error_page);
                 exit;
             }
             else {
                 throw new Simple_Exception("error not find ");
             }
        }
        $result_class = $this->formatToClass($result);
        $controller = new $result_class['controller']($result, $this->request, $this->response, $this);
        if (! method_exists($controller, $result_class['action'])) {
             $config = Simple_Registry::get("config");
             $error_page = $config->getOption($result['app'], "error_page"); 
             $global_error_page =  $config->getGlobalOption("error_page"); 
             if(!$this->diff($result, $global_error_page) ){
                 throw new Simple_Exception("2error not find ");
             } else if($this->diff($result, $error_page)){
                 $this->app($error_page);
                 exit;
             } else {
                 throw new Simple_Exception("3error not find ");
             }
        }
        $controller->$result_class['action']();
        $view = $this->response->render($result);
        return $view;
    }
    public function validApp($result)
    {
        
        $result = $this->arraytolower($result);
        if(empty($result['app']) || empty($result['controller']) || empty($result['action']))
        {
            throw new Simple_Exception("empty!");
        }
        $config = Simple_Registry::get("config");
        $app_home_path = $config->getOption($result['app'], "app_home");
        $app_path = $app_home_path . "/" . $result['app'] . "/controller";
        
        if (! is_dir($app_path)) {
            throw new Simple_Exception("$app_path not find ");
        }
        $result_file = $this->formatToFile($result);
        $controller_path = $app_path . "/" . $result_file['controller'];
        if (! file_exists($controller_path)) {
            throw new Simple_Exception("$controller_path not find ");
        }
        $result_class = $this->formatToClass($result);
        if (! class_exists($result_class['controller'])) {
            include_once $controller_path;
        }
        return $result;
    }
    public function validController($result)
    {
        $result_class = $this->formatToClass($result);
        if(! class_exists($result_class['controller']))
        {
              throw new Simple_Exception("{$result_class['controller']} not find ");
        }
        return $result;
    }
    public function arraytolower($result)
    {
        foreach ($result as $k => $v) {
            $arr[$k] = strtolower($v);
        }
        return $arr;
    }
    public function diff($arr1, $arr2)
    {
        foreach($arr1 as $k=>$v)
        {
            if($v != $arr2[$k]) 
                return true;
        }
        return false;
    }
    public function formatToFile($result)
    {
        $config = Simple_Registry::get("config");
        $controller_suffix = $config->getOption($result['app'], "controller_suffix");
        if (empty($controller_suffix)) {
            $controller_suffix = ".php";
        } else {
            $controller_suffix = "." . $controller_suffix . ".php";
        }
        $result_format['app'] = strtolower($result['app']);
        $result_format['controller'] = strtolower($result['controller']) . $controller_suffix;
        $result_format['action'] = strtolower($result['action']);
        return $result_format;
    }
    public function formatToClass($result)
    {
        $config = Simple_Registry::get("config");
        $controller_suffix = $config->getOption($result['app'], "controller_suffix");
        $action_suffix = $config->getOption($result['app'], "action_suffix");
        $result_format['app'] = strtolower($result['app']);
        $result_format['controller'] = ucfirst(strtolower($result['controller'])) . ucfirst($controller_suffix);
        $result_format['action'] = ucfirst(strtolower($result['action'])) . ucfirst($action_suffix);
        return $result_format;
    }
}

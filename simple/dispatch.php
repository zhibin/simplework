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
    public function app($result, $layout = false)
    {
        $result = $this->arraytolower($result);
        $this->response->clear();
        if (! $layout) {
            if ($this->response->_isrender)
                $suffix = "Action"; else
                $suffix = "Layout";
        } else {
            $suffix = "Layout";
        }
        try {
            $result_class = $this->validController($result, $suffix);
        } catch (Simple_Exception $e) {
            try {
                $result_class = $this->validController(array("app" => "error" , "controller" => "error" , "action" => "error"), $suffix);
            } catch (Simple_Exception $e) {
                throw new Simple_Exception("error not find ");
            }
        }
        $controller = new $result_class['controller']($result, $this->request, $this->response, $this);
        if (! method_exists($controller, $result_class['action'])) {
            if (method_exists($controller, "errorAction")) {
                $result_class['action'] = "errorAction";
                $result['action'] = "error";
            } else {
                if ($result_class['action'] == "ErrorAction") {
                    $this->app(array("app" => "error" , "controller" => "error" , "action" => "error"));
                } else {
                    $this->app(array("app" => $result['app'] , "controller" => "error" , "action" => "error"));
                }
                exit();
            }
        }
        $controller->$result_class['action']();
        $view = $this->response->render($result);
        return $view;
    }
    public function validController($result, $suffix)
    {
        $result_class = $this->formatToClass($result, $suffix);
        $result_file = $this->formatToFile($result);
        $app = $result_class['app'];
        $controller = $result_class['controller'];
        $action = $result_class['action'];
        $config = Simple_Registry::get("config");
        $app_home_path = $config->getOption($app, "app_home");
        $app_path = $app_home_path . "/" . $app . "/controller";
        if (! is_dir($app_path)) {
            throw new Simple_Exception("$app_path not find ");
        }
        $controller_path = $app_path . "/" . $result_file['controller'];
        if (! file_exists($controller_path)) {
            throw new Simple_Exception("$controller_path not find ");
        }
        if (! class_exists($controller)) {
            include_once $controller_path;
        }
        if (! class_exists($controller)) {
            throw new Simple_Exception("$controller not find ");
        }
        return $result_class;
    }
    public function arraytolower($result)
    {
        foreach ($result as $k => $v) {
            $arr[$k] = strtolower($v);
        }
        return $arr;
    }
    public function formatToFile($result)
    {
        $result_format['app'] = strtolower($result['app']);
        $result_format['controller'] = strtolower($result['controller']) . ".controller.php";
        $result_format['action'] = strtolower($result['action']);
        return $result_format;
    }
    public function formatToClass($result, $suffix)
    {
        $result_format['app'] = strtolower($result['app']);
        $result_format['controller'] = ucfirst(strtolower($result['controller'])) . "Controller";
        $result_format['action'] = ucfirst(strtolower($result['action'])) . $suffix;
        return $result_format;
    }
}

<?php
class Simple_Response
{
    public $params = array();
    public $isrender = true;
    public $dispatch = null;
    public $headers = array();
    public $contexts = array();
    public function getDispatch($dispatch)
    {
        $this->dispatch = $dispatch;
    }
    public function setContext($name, $value)
    {
        $this->contexts[$name] = $value;
    }
    public function getContext($name)
    {
         return $this->contexts[$name];
    }
    public function __set($name, $value)
    {
        $this->params[$name] = $value;
    }
    public function __get($name)
    {
        return $this->params[$name];
    }
    public function clear()
    {
        $this->params = array();
    }
    public function setLayout($name, $app)
    {
        $config = Zend_Registry::get("config");
        $layout_home_path = $config->app_home .'/'.$config->app_dir. '/' . $app . '/view/layout';
        $layout_template = $layout_home_path."/".$name;
        if(!file_exists($layout_template))
        {
            throw new Simple_Exception("$defaulttemplate not find");
        }
        $layout = new Simple_Layout($layout_template, $this);
        $this->isrender = false;
        return $layout;
    }
    public function render($map)
    {
        $config = Zend_Registry::get("config");
        $view_home_path = $config->app_home .'/'.$config->app_dir. '/' . $map['app'] . '/view';
        $template = $this->template;
        if (! empty($template)) {
            $default_template = $view_home_path . $template;
        } else {
            $tpl_name = $map['action'];
            $default_template = $view_home_path . '/' . $tpl_name . ".view.htm";
        }
        if(!file_exists($default_template))
        {
            throw new Simple_Exception("$default_template not find");
        }
        $view = new Simple_View($default_template, $this);
        if ($this->isrender) {
            $view->render();
        }
        return $view;
    }
    public function header($key, $value)
    {
        $this->headers[$key] = $value;
    }
    public function sendHeader()
    {
        if(!empty($this->headers))
        foreach ($this->headers as $k => $v)
        {
            header("$k:$v");
            if($k == "Location") exit;
        }
    }
    public function jump($url)
    {
        header("Location:$url");
        exit;
    }
    public function getUrl($map)
    {
        $router = $this->dispatch->rewrite->getRouter($map);
        return $router->getUrl($map);
    }
    public function dispatch($map)
    {
        return $this->dispatch->app($map);
    }
}

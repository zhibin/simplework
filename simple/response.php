<?php
class Simple_Response
{
    private $params = array();
    public $isrender = true;
    public $dispatch;
    public $header = array();
    public function getDispatch($dispatch)
    {
        $this->dispatch = $dispatch;
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
        $config = Simple_Registry::get("config");
        $layout_home_path = $config->getOption($app, "app_home") . '/' . $app . '/layout';
        $layout = new Simple_Layout($layout_home_path . "/" . $name, array(), $this);
        $this->isrender = false;
        return $layout;
    }
    public function render($map)
    {
        $config = Simple_Registry::get("config");
        $view_home_path = $config->getOption($map['app'], "app_home") . '/' . $map['app'] . '/view';
        $template = $this->template;
        if (! empty($template)) {
            $defaulttemplate = $view_home_path . $template;
        } else {
            $tpl_name = $map['action'];
            $defaulttemplate = $view_home_path . '/' . $tpl_name . ".view.htm";
        }
        if(!file_exists($defaulttemplate))
        {
            throw new Simple_Exception("$defaulttemplate not find");
        }
        $view = new Simple_View($defaulttemplate, $this->params, $this);
        if ($this->isrender) {
            $view->render();
        }
        return $view;
    }
    public function header($key, $value)
    {
        $this->header[$key] = $value;
    }
    public function sendHeader()
    {
        if(!empty($this->header))
        foreach ($this->header as $k => $v)
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
}

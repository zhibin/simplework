<?php
class Simple_Response
{
    private $_params = array();
    public $_isrender = true;
    public $_dispatch;
    public function getDispatch($dispatch)
    {
        $this->_dispatch = $dispatch;
    }
    public function __set($name, $value)
    {
        $this->_params[$name] = $value;
    }
    public function __get($name)
    {
        return $this->_params[$name];
    }
    public function clear()
    {
        $this->_params = array();
    }
    public function setLayout($name, $app)
    {
        $config = Simple_Registry::get("config");
        $layout_home_path = $config->getOption($app, "app_home") . '/' . $app . '/layout';
        $layout = new Simple_Layout($layout_home_path . "/" . $name, array(), $this);
        $this->_isrender = false;
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
        $view = new Simple_View($defaulttemplate, $this->_params, $this);
        if ($this->_isrender) {
            $view->render();
        }
        return $view;
    }
    public function getUrl($map)
    {
        $router = $this->_dispatch->rewrite->getRouter($map);
        return $router->getUrl($map);
    }
}

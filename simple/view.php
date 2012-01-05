<?php
class Simple_View
{
    public $_params;
    public $_template;
    public $_response;
    public function __construct($template, $params = array(), $response)
    {
        $this->_params = $params;
        $this->_template = $template;
        $this->_response = $response;
    }
    public function render()
    {
        include $this->_template;
    }
    public function __set($key, $value)
    {
        $this->_params[$key] = $value;
    }
    public function __get($key)
    {
        $view = $this->_params[$key];
        if ($view instanceof Simple_View) {
            $this->_params[$key]->render();
        } else {
            return $this->_params[$key];
        }
    }
    public function action($map)
    {
        $oldstatus = $this->_response->_isrender;
        $this->_response->_isrender = true;
        $view = $this->_response->_dispatch->app($map, true);
        $this->_response->_isrender = $oldstatus;
    }
    public function getUrl($map)
    {
        return $this->_response->getUrl($map);
    }
}

<?php
class Simple_View
{
    public $params = array();
    public $template;
    public $response;
    public function __construct($template, $response)
    {
        $this->template = $template;
        $this->response = $response;
    }
    public function render()
    {
        include $this->template;
    }
    public function __set($key, $value)
    {
        $this->params[$key] = $value;
    }
    public function __get($key)
    {
        if (array_key_exists($key, $this->params)) {
            $value = $this->params[$key];
        } else if (array_key_exists($key, $this->response->params)) {
            $value = $this->response->params[$key];
        } else if (array_key_exists($key, $this->response->contexts)) {
            $value = $this->response->contexts[$key];
        } else {
            $value = "";
        }
        if ($value instanceof Simple_View) {
            $value->render();
        } else {
            return $value;
        }
    }
	public function __isset($key) 
	{
    	return isset($this->response->params[$key]);

  	}
    public function action($map)
    {
        $oldstatus = $this->response->isrender;
        $this->response->isrender = true;
        $view = $this->response->dispatch->app($map);
        $this->response->isrender = $oldstatus;
    }
    public function url($map)
    {
        return $this->response->url($map);
    }
}

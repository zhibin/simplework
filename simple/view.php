<?php
class Simple_View
{
    public $params;
    public $template;
    public $response;
    public function __construct($template, $params = array(), $response)
    {
        $this->params = $params;
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
        $view = $this->params[$key];
        if ($view instanceof Simple_View) {
            $this->params[$key]->render();
        } else {
            return $this->params[$key];
        }
    }
    public function action($map)
    {
        $oldstatus = $this->response->isrender;
        $this->response->isrender = true;
        $view = $this->response->dispatch->app($map);
        $this->response->isrender = $oldstatus;
    }
    public function getUrl($map)
    {
        return $this->response->getUrl($map);
    }
}

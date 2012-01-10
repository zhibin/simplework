<?php
class Simple_Rewrite
{
    public $request;
    public $routers;
    public function __construct($request)
    {
        $this->request = $request;
        $this->routers['Simple_Router'] = new Simple_Router($this->request);
    }
    public function addRouter($router)
    {
        $this->routers[$router] = new $router($this->request);
    }
    public function analysis()
    {
        foreach ($this->routers as $k => $v) {
            if ($v->match())
                break;
        }
    }
    public function getResult()
    {
        return array("app" => $this->request->app , "controller" => $this->request->controller , "action" => $this->request->action);
    }
    public function getRouter($map)
    {
      
        $config = Zend_Registry::get("config");
        if (! array_key_exists($map[0], $config->app->toArray())) {
            throw new Simple_Exception("{$map[0]} not find");
        }
        $router = $this->routers[$config->app->{$map[0]}->router];
        return $router;
    }
}

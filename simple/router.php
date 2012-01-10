<?php
class Simple_Router
{
    public $request;
    public function __construct($request)
    {
        $this->request = $request;
    }
    public function match()
    {
        $app = $this->request->app;
        $c = $this->request->c;
        $a = $this->request->a;
        if (! empty($app) || ! empty($c) || ! empty($a)) {
            $this->getParams();
            return true;
        } else {
            $uri = $this->request->getUri();
            if ($uri == '/' || preg_match("/^\/\w++\.php$/i", $uri) || preg_match("/^\/(?:\w++\.php)?(?:\?|#)/i", $uri)) {
                $this->getParams();
                return true;
            } else {
                return false;
            }
        }
    }
    private function getParams()
    {
        $app = $this->request->app;
        $c = $this->request->c;
        $a = $this->request->a;
        $config = Zend_Registry::get("config");
        if (empty($app)) {
               
            $this->request->app = $config->home_page->app;
        } else {
            $this->request->app = $app;
        }
        if (empty($c)) {
            $this->request->controller = $config->home_page->controller;
        } else {
            $this->request->controller = $c;
        }
        if (empty($a)) {
            $this->request->action = $config->home_page->action;
        } else {
            $this->request->action = $a;
        }
    }
    public function getUrl($map)
    {
        $config = Zend_Registry::get("config");
        if ($map[0] != $config->home_page->app) {
            $query_array['app'] = strtolower($map[0]);
        }
        if ($map[1] != $config->home_page->controller) {
            $query_array['c'] = strtolower($map[1]);
        }
        if ($map[2] != $config->home_page->action) {
            $query_array['a'] = strtolower($map[2]);
        }
        if (! empty($map[3])) {
            $query_array = array_merge($query_array, $map[3]);
        }
        if (! empty($map[4])) {
            $query_array = array_merge($query_array, $map[4]);
        }
        if (! empty($query_array)) {
            $query_string = http_build_query($query_array);
            $url = "/?" . $query_string;
        } else {
            $url = "/";
        }
        return $url;
    }
}

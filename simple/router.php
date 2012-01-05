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
        $config = Simple_Registry::get("config");
        if (empty($app)) {
            $home_page = $config->getOption("global", "home_page");
            $this->request->app = $home_page[0];
        } else {
            $this->request->app = $app;
        }
        if (empty($c)) {
            $home_page = $config->getOption($this->request->app, "home_page");
            $this->request->controller = $home_page[1];
        } else {
            $this->request->controller = $c;
        }
        if (empty($a)) {
            $home_page = $config->getOption($this->request->app, "home_page");
            $this->request->action = $home_page[2];
        } else {
            $this->request->action = $a;
        }
    }
    public function getUrl($map)
    {
        $config = Simple_Registry::get("config");
        $home_page = $config->getOption($map[0], "home_page");
        if ($map[0] != $home_page[0]) {
            $query_array['app'] = strtolower($map[0]);
        }
        if ($map[1] != $home_page[1]) {
            $query_array['c'] = strtolower($map[1]);
        }
        if ($map[2] != $home_page[2]) {
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
<?php
class Simple_Request
{
    public $params;
    public function __set($key, $value)
    {
        $this->params[$key] = $value;
    }
    public function get($key)
    {
        switch (true) {
            case isset($this->params[$key]):
                return $this->params[$key];
            case isset($_GET[$key]):
                return $_GET[$key];
            case isset($_POST[$key]):
                return $_POST[$key];
        }
        return null;
    }
    public function __get($key)
    {
        return $this->get($key);
    }
    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
    public function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }
}

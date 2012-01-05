<?php
class Simple_Request
{
    public $_params;
    public function __set($key, $value)
    {
        $this->_params[$key] = $value;
    }
    public function get($key)
    {
        switch (true) {
            case isset($this->_params[$key]):
                return $this->_params[$key];
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
}

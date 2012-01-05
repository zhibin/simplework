<?php
class Simple_Autoload
{
    public function __construct()
    {
        spl_autoload_register(array($this , 'loader'));
    }
    public function registerAutoload($loader)
    {
        spl_autoload_register($loader);
    }
    private function loader($className)
    {
        if (preg_match('/^Simple_(.*?)$/i', $className, $match)) {
            $filename = strtolower($match[1]) . ".php";
            include dirname(__FILE__) . DIRECTORY_SEPARATOR . $filename;
        }
        if (preg_match('/^Work_(.*?)_(.*?)$/i', $className, $match)) {
            $path = strtolower($match[1]);
            $filename = strtolower($match[2]) . ".php";
            include dirname(__FILE__) . DIRECTORY_SEPARATOR . "../work/" . $path . "/" . $filename;
        }
    }
}
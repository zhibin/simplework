<?php
class Work_Unitofwork_Unit
{
    protected $obj;
    protected function __get($key)
    {
        return $this->obj[$key];
    }
    protected function __set($key, $value)
    {
        $this->obj[$key] = $value;
    }
    public function __construct()
    {
        $depends = $this->depend();
        if (! empty($depends)) {
            foreach ($depends as $k => $v) {
                if (! class_exists($v)) {
                    throw new Simple_Exception("work not exists");
                }
                if (! $this->obj[$k]) {
                    $obj = new $v();
                    $work = $obj->loader();
                    $this->$k = $work;
                }
            }
        }
    }
    public function depend()
    {
        return array("zend_db" => "Work_Db_Zend");
    }
    public function loader()
    {
        if (! Simple_Registry::isRegistered("unitofwork")) {
            $autoload = Simple_Autoload::getInstance();
            $autoload->registerAutoload(array($this , "autoload"));
            $zend_db = $this->zend_db;
            include_once "unitofwork.php";
            include_once "entity.php";
            $unitofwork = UnitofWork::getInstance();
            $unitofwork->setDb($zend_db);
            Simple_Registry::set("unitofwork", $unitofwork);
            return $unitofwork;
        } else {
            return Simple_Registry::get("unitofwork");
        }
    }
    public function autoload($className)
    {
        if (preg_match('/^(.*?s)Entity$/i', $className, $match)) {
            $filename = strtolower($match[1]) . ".php";
            $config = Simple_Registry::get("config");
            $entity_path = $config->getGlobalOption("entity_path");
            include $entity_path . "/" . $filename;
        }
    }
}
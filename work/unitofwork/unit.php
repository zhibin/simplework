<?php
class Work_Unitofwork_Unit extends Simple_Work 
{
    public $unitofwork;
    public function depend()
    {
        return array("Work_Db_Simple");
    }
    public function loader($param=array())
    {
            $autoload = Simple_Autoload::getInstance();
            $autoload->registerAutoload(array($this , "autoload"));
            include_once "unitofwork.php";
            include_once "entity.php";
            $unitofwork = UnitofWork::getInstance();
            $this->unitofwork = $unitofwork;
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
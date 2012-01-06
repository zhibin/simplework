<?php
class Work_Unitofwork_Unit extends Simple_Work
{
    public function depend()
    {
        return array("zend_db" => "Work_Db_Zend");
    }
    public function loader()
    {
        $autoload = Simple_Autoload::getInstance();
        $autoload->registerAutoload(array($this , "autoload"));
        $zend_db = $this->zend_db;
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
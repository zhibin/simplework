<?php
class Work_Db_Zend
{
    public function loader()
    {
        set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../');
        require_once "Zend/Db.php";
        $config = Simple_Registry::get("config");
        $params = array('host' => $config->getGlobalOption('db_host') ,
                         'username' => $config->getGlobalOption('db_user') ,
                         'password' => $config->getGlobalOption('db_pass') ,
                         'dbname' => $config->getGlobalOption('db_name'));
        $db = Zend_Db::factory('Mysqli', $params);
        Simple_Registry::set("zend_db", $db);
        return $db;
    }
}
?>
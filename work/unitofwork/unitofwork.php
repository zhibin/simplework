<?php
class UnitofWork
{
    public static $handle;
    public $db;
    private function __construct()
    {
        
    }
    public static function getInstance()
    {
        if(self::$handle == null)
        {
           
            self::$handle = new self();
            self::$handle->db = Simple_Registry::loader("Work_Db_Simple");
        }
        return self::$handle;
    }
    public function createEntity($sql, $entity)
    {
        
    }
}
?>
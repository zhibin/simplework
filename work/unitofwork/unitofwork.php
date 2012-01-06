<?php
class UnitofWork
{
    public static $handle;
    public $db;
    private function __construct()
    {
        
    }
    public function getInstance()
    {
        if(self::$handle == null)
        {
            self::$handle = new self();
        }
        return self::$handle;
    }
    public function setDb($db)
    {
        $this->db = $db;
    }
    public function createEntity($sql, $entity)
    {
        
    }
}
?>
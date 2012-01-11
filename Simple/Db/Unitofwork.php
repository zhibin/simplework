<?php
class Simple_Db_Unitofwork 
{
    public static $unitofwork;
    public $db;
    public $lists = array();
    private function __construct()
    {
          
    }
    public function  getInstance()
    {
        if(self::$unitofwork == null)
        {
            self::$unitofwork = new self();
            self::$unitofwork->db  = Simple_Db_Mysql::getInstance();
        }
        return self::$unitofwork;
    }
    public function register($entity)
    {
        $this->lists[$entity->getKey()] = $entity;
    }
    public function get($key)
    {
       return $this->lists[$key];
    }
}
?>
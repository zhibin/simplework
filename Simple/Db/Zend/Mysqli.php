<?php
class Simple_Db_Zend_Mysqli
{
    public $db;
    public static $handles = array();
    private  function __construct()
    {
       
    }
    public static function getInstance($params = array(), $key = "master")
    {
        if(!array_key_exists($key, self::$handles))
        {
            $mysql = new self();
            self::$handles[$key] = $mysql->init($params);
            
        }
        return self::$handles[$key];
        
          
    }
    public function init($params)
    {
        $config = Zend_Registry::get("config");
        if(empty($params))
        {
           $params = $config->database->master->toArray();
        }
        $db_config = array('host' => $params['db_host'] ,
                                 'username' => $params['db_user'] ,
                                 'password' => $params['db_pass'] ,
                                 'dbname' => $params['db_name']);
        $type = $config->database->type;  
        $this->db = Zend_Db::factory($type, $db_config); 
        return $this->db;
    }
    public function resource()
    {
        return $this->db;
    }
    public function fetch($sql, $bind=array())
    {
	   $row = $this->db->fetchRow($sql, $bind);
       return $row;
    }
    public function fetchAll($sql, $bind=array())
    {
       return $this->db->fetchAll($sql, $bind);
    }
}
?>
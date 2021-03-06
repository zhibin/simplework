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
            $mysql->init($params);
            self::$handles[$key] = $mysql;
            
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
        $this->db->query("set names {$params['db_charset']}");
        return $this->db;
    }
    public function resource()
    {
        return $this->db;
    }
    public function fetch($sql, $bind=array())
    {
        try{
         $row = $this->db->fetchRow($sql, $bind);
        }catch (Zend_Db_Exception  $e)
        {
           throw new Simple_Exception($sql);
           exit;
        }
       return $row;
    }
    public function fetchAll($sql, $bind=array())
    {
     try{
         $rows = $this->db->fetchAll($sql, $bind);;
        }catch (Zend_Db_Exception  $e)
        {
           throw new Simple_Exception($sql);
           exit;
        }
       return $rows;
    }
    public function query($sql, $bind=array())
    {
        try{
         $stmt = $this->db->query($sql, $bind);
        }catch (Zend_Db_Exception  $e)
        {
          
           throw new Simple_Exception($sql);
           exit;
        }
         return $stmt->rowCount();
    }
}
?>
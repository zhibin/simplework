<?php
class Work_Db_Zend   extends Simple_Work 
{
    public $db;
    public $db_key;
    public function loader($param =array())
    {
            $this->db_key = $param['key'];
            set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../');
            require_once "Zend/Db.php";
         
            $params = array('host' => $param['db_host'] ,
                             'username' => $param['db_user'] ,
                             'password' => $param['db_pass'] ,
                             'dbname' => $param['db_name']);
            $this->db = Zend_Db::factory('Mysqli', $params);
    }
    public function getDbHandle()
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




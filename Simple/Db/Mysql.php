<?php
class Simple_Db_Mysql
{
    public static $handle;
    public $db_handles = array();
    public $db_master;
    public $db_slave;
    private function __construct()
    {}
    public static function getInstance()
    {
        if (self::$handle == null) {
            self::$handle = new self();
            self::$handle->init();
        }
        return self::$handle;
    }
    private function init()
    {
        $config = Zend_Registry::get("config");
        $type = $config->database->type;
        $db_config = $config->database->db;
        $percent = 0;
        switch ($type) {
            case "Pdo_Mysql":
            case "Mysqli":
                foreach ($db_config as $k => $v) {
                    $params = $v->toArray();
                    $this->db_handles[$k] = array(Simple_Db_Zend_Mysqli::getInstance($params, $k) , $percent , $params['db_percent'] + $percent);
                    $percent += $params['db_percent'];
                }
                break;
            case "Mysql":
            default:
                break;
        }
        $this->db_master = $this->getDbHandle("master");
        $this->db_slave = $this->getDbHandle();
    }
    public function getDbHandle($key = "")
    {
        if ($key == "master") {
            return $this->db_handles['master'][0];
        } else {
            $r = rand(1, 100);
            foreach ($this->db_handles as $k => $v) {
                if ($k == "master")
                    continue;
                if ($r >= $v[1] && $r <= $v[2]) {
                    return $this->db_handles[$k][0];
                }
            }
        }
    }
    public function resource()
    {
        return array("master" => $this->db_master , "slaver" => $this->db_slave);
    }
    public function fetch($sql, $bind = array())
    {
        return $this->db_slave->fetch($sql, $bind);
    }
    public function fetchAll($sql, $bind = array())
    {
        return $this->db_slave->fetchAll($sql, $bind);
    }
    public function query($sql , $bind=array())
    {
         return $this->db_master->query($sql, $bind); 
    }
    public function update($sql, $bind=array())
    {
        return $this->query($sql, $bind); 
    }
    public function insert($sql, $bind=array())
    {
        return $this->query($sql, $bind); 
    }
}
?>
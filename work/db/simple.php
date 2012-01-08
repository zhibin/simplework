<?php
class Work_Db_Simple extends Simple_Work
{
    public $db_handle = array();
    public $db_master;
    public $db_slave;
    public function loader($param=array())
    {
        
    
            $config = Simple_Registry::get("config");
            $db_type = $config->getGlobalOption("db_type");
            $db_config = $config->getGlobalOption("db_config");
            
            
            switch ($db_type)
            {
                
                case "mysqlp":
                case "mysqli":
                    $num = 0;
                    foreach($db_config as $k => $v)
                    {
                        $param = $v;
                        $param['key']= $k;
                        $work_zend_db = Simple_Registry::loader("Work_Db_Zend", $param);
                        $this->db_handle[$k] = array($work_zend_db, $num, $v['db_percent']+$num);
                        $num += $v['db_percent'];
                    }
                    break;
                    
                case "mysqls":
                default:
                         
                break;
            }
            $this->db_master = $this->getDbHandle("master");
            $this->db_slave = $this->getDbHandle();
    }
    public function getDbHandle($key = "")
    {
       
        if($key == "master")
        {
            return $this->db_handle['master'][0];
        }
        else
        {
             $r = rand(1, 100);
             foreach($this->db_handle as $k => $v)
             {
                 if($k == "master") continue;
                 if($r >= $v[1] && $r <=  $v[2])
                 {
                    return $this->db_handle[$k][0]; 
                 }
                 
             }
             
             
        }
    }
    public function resource()
    {
        return array("master"=>$this->db_master,"slaver"=>$this->db_slave);
    }
    
    public function fetch($sql, $bind = array())
    {
        return  $this->db_slave->fetch($sql,$bind);
    }
	public function fetchAll($sql, $bind = array())
	{
		return $this->db_slave->fetchAll($sql, $bind);
	}
}
?>




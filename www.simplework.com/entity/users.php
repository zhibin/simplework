<?php
class Users extends Simple_Db_Entity
{
    
    public   $column =array(
					"id",
					"version",
				    "username",
                    "nick",
                    "qqid",
                    "sinaid",
                    "password",
                    "pwd",
                    "email",
					"ctime",
					"mtime",
					);
					
	public $table = "users";
	public $default_select_column = 
	            array("id",
					"version",
				    "password",
					"ctime");
	public static function createBy($row)
	{
	     $entity = new self();
	     $row['ctime'] = $row['mtime'] = time();
	     $entity = $entity->create($row);
	     return $entity;				
	}
    public static function getById($id)
    {
       $entity = new self();
       $entity->default_select_column = array('id');
       $entity = $entity->getByIndex($id);
       return $entity;
    }
    public static function getByName($name)
    {
      
       $entity = new self();
       $where = "username='$name'";
       $entity = $entity->getOne($where);
       return $entity;
    }
    public static function getBySinaid($sinaid)
    {
      
       $entity = new self();
       $where = "sinaid='$sinaid'";
       $entity = $entity->getOne($where);
       return $entity;
    }
    public static function getByQQid($qqid)
    {
       $entity = new self();
       $where = "qqid='$qqid'";
       $entity = $entity->getOne($where);
       return $entity;
    }
    
}

?>
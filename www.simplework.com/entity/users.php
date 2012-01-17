<?php
class Users extends Simple_Db_Entity
{
    public   $column =array(
					"id",
					"version",
				    "password",
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
}

?>
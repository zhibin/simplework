<?php
class Users extends Simple_Db_Entity
{
    
    public   $column =array(
					"id",
					"version",
				    "name",
					"ctime",
					"mtime",
					);
					
	public $table = "users";				
    public static function getById($id)
    {
       $entity = new self();
       $entity = $entity->getByIndex($id);
       return $entity;
    }
    public static function getByName($name)
    {
      
       $entity = new self();
       $sql = "select * from {$entity->table} where username='$name'";
       $entity = $entity->getOne($sql);
       return $entity;
    }
}

?>
<?php
class Users extends Simple_Db_Entity
{
    const email_empty = 2;
    public   $column =array(
					"id",
					"version",
				    "password",
					"ctime",
					"mtime",
					);
					
	public $table = "users";
	public static function createBy($row)
	{
	     $entity = new self();
	     $entity = $entity->create($row);
	     return $entity;				
	}
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
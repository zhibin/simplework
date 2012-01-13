<?php
class Directorys extends Simple_Db_Entity
{
    public   $column =array(
					"id",
					"version",
					"ctime",
					"mtime",
					);
					
	public $table = "directorys";
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
}

?>
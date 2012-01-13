<?php
class Articles extends Simple_Db_Entity
{
    public   $column =array(
					"id",
					"version",
					"directoryid",
					"mtime",
					);
					
	public $table = "articles";
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
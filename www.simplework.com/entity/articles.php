<?php
class Articles extends Simple_Db_Entity
{
    public   $column =array(
					"id",
					"version",
    				"categoryid",
                    "title",
    				"content",
    				"fromto",
                    "status",
                    "sign",
					"ctime",
					"mtime",
					);
					
	public $table = "articles";
	public function beLongToMap()
	{
		return array("category"=>array("entity"=>"Categorys","param"=>"categoryid")
						);
	}
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
    public static function getByAll()
    {
       $entity = new self();
       $entity->default_select_column = array();
       $entitys = $entity->getAll();
       return $entitys;
    }
	public function ctime()
    {
    	return date("Y-m-d H:i:s", $this->ctime);
    }
	public function mtime()
    {
    	return date("Y-m-d H:i:s", $this->mtime);
    }	
}

?>
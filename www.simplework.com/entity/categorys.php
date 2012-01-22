<?php
class Categorys extends Simple_Db_Entity 
{
	public $column =array(
					"id",
					"version",
					"fid",
					"ffid",
                    "name",
                    "sign",
	   				"status",
					"ctime",
					"mtime",
					);
					
	public $table = "categorys";
	public static function createBy($row)
	{
		
		 $row['ctime'] = $row['mtime'] = time();
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
    public static function getByFid($fid)
    {
       $entity = new self();
       $entitys = $entity->getAll("fid='$fid'");
       return $entitys;			
    }
    public function ctime()
    {
    	return date("Y-m-d H:i:s", $this->ctime);
    }
}
?>
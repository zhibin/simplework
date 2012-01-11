<?php
class Simple_Db_Entity
{
    private  $unitofwork;
    public  $row;
    private  $key;
    public function __construct()
    {
        $this->unitofwork = Simple_Db_Unitofwork::getInstance();
    }
    public function getKey()
    {
		return $this->key;
    }
    public function setKey($id)
    {
        $this->key = $id.'_'.$this->table;
        return $this->key;
    
    }
    public function getByIndex($id)
    {
           $key = $id."_".$this->table;
           $entity = $this->unitofwork->get($key);
           if(empty($entity))
           {
               $row = $this->unitofwork->db->fetch("select * from  {$this->table} where id =$id");
               if(!empty($row))
               {
                   $this->setKey($row['id']);
                   $this->row = $row;
                   $this->unitofwork->register($this);
                   return $this;
               }
               return $this;
           }
           return $entity;
    }
    public function isEmpty()
    {
        if(empty($this->key))
            return true;
        else
            return false;
    }
    public function getOne($sql, $bind=array())
    {
          $row = $this->unitofwork->db->fetch($sql);
          if(!empty($row))
          {
              $entity = $this->unitofwork->get($this->setKey($row['id']));
              if(empty($entity))
              {
                  $this->row = $row;
                  $this->unitofwork->register($this);
                  return $this;
              }
              return $entity;
          }
          return $this;
          
    }
    public function getAll($sql, $bind=array())
    {
          $rows = $this->unitofwork->db->fetchAll($sql);
          if(!empty($rows))
          {
              $entitys = array();
              foreach($rows as $k => $row)
              {
                  $key = $row['id']."_".$this->table;
                  $entity = $this->unitofwork->get($key);
                  if(empty($entity))
                  {
                      $this->setKey($row['id']);
                      $this->row = $row;
                      $this->unitofwork->register($this);
                      $entity = $this;
                  } 
                  $entitys[] = $entity;
              }
          }
          return $entitys;
          
    }
}

?>
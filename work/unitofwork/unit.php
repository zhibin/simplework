<?php
class Work_Unitofwork_Unit extends Simple_Work
{
    public function depend()
    {
        return array("zend_db"=>"Work_Db_Zend");
    }
    public function loader()
    {
       $zend_db = $this->zend_db;
    }
}
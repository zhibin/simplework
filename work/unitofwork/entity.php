<?php
class Work_Unitofwork_Entity
{
    public function depend()
    {
        return array("unit"=>"Work_Unitofwork_Unit");
    }
    public function getUnit()
    {
        return  Work_Unitofwork_Unit::$work;
    }
    public function getEntityById($id)
    {
     
        print_r($this->getUnit());
    }
}


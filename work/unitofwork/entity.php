<?php
class Entity
{
    public $unitofwork;
    public function __construct()
    {
        $this->unitofwork = UnitofWork::getInstance();
    }
    public function getEntity($sql)
    {
        $unitofwork->createEntity($sql, $this);
        return $this;
    }
}


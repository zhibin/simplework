<?php
class Simple_Db_Unitofwork
{
    public static $unitofwork;
    public $lists = array();
    public $db;
    public $insertlist = array();
    public $updatelist = array();
    public $deletelist = array();
    private function __construct()
    {}
    public function getInstance()
    {
        if (self::$unitofwork == null) {
            self::$unitofwork = new self();
            self::$unitofwork->db = Simple_Db_Mysql::getInstance();
        }
        return self::$unitofwork;
    }
    public function register($entity)
    {
        $this->lists[$entity->getKey()] = $entity;
    }
    public function get($key)
    {
        return $this->lists[$key];
    }
    public function makeSqllist()
    {
        if (! empty($this->lists)) {
            foreach ($this->lists as $k => $v) {
                $insertSql = $v->getInsertSql($v);
                if (! empty($insertSql)) {
                    $this->insertlist[$k] = $insertSql;
                    $v->iscreate = false;
                }
                $updateSql = $v->getUpdateSql($v);
                if (! empty($updateSql)) {
                    $this->updatelist[$k] = $updateSql;
                }
                $deleteSql = $v->getDeleteSql($v);
                if (! empty($deleteSql)) {
                    $this->deletelist[$k] = $deleteSql;
                }
            }
        }
    }
    public function commit()
    {
        $db = Simple_Db_Mysql::getInstance();
        $this->makeSqllist();
        if (! empty($this->insertlist))
            foreach ($this->insertlist as $insert) {
                $db->query($insert);
            }
        if (! empty($this->updatelist))
            foreach ($this->updatelist as $update) {
                $rowCount = $db->query($update);
                if ($rowCount == 0)
                    throw new Simple_Exception("unitofwork not update success! version check clash", 1);
            }
        if (! empty($this->deletelist))
            foreach ($this->deletelist as $delete) {
                $rowCount = $db->query($delete);
                if ($rowCount == 0)
                    throw new Simple_Exception("unitofwork not delete success! version check clash", 1);
            }
    }
}
?>
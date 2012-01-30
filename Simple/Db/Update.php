<?php
class Simple_Db_Update
{
    public $class;
    public $entity;
    public $bind = array();
    public $pre = false;
    public function __construct($class)
    {
        $this->class = $class;
        $this->entity = new $class();
    }
    public static function create($class)
    {
        return new self($class);
    }
    public function set($set)
    {
        $this->set = $set;
        return $this;
    }
    public function precheck($entity_cloumn)
    {
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        if (! empty($entity_cloumn)) {
            foreach ($entity_cloumn as $key => $value) {
                $cloumn_arr = explode(".", $value);
                $class = $cloumn_arr[0];
                $cloumn = $cloumn_arr[1];
                $entity_list = $unitofwork->getTree($class);
                if (! empty($entity_list)) {
                    foreach ($entity_list as $k => $v) {
                        if (($v->iscreate || array_key_exists($cloumn, $v->updatestack)) && ! $v->isdelete) {
                            trigger_error("where update not commit db", E_USER_ERROR);
                            exit();
                        }
                    }
                }
            }
            $this->pre = true;
        } else {
            $this->pre = false;
        }
        return $this;
    }
    public function where($where, $bind = array())
    {
        $this->where = $where;
        $this->bind = $bind;
        return $this;
    }
    public function end()
    {
        if (! $this->pre) {
            trigger_error("please input percheck", E_USER_ERROR);
            exit();
        }
        $select_sql = "select id from " . $this->entity->table . (($this->where) ? " where $this->where" : '');
        $row = Simple_Db_Mysql::getInstance()->fetchAll($select_sql, $this->bind);
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $in = array();
        if (! empty($row))
            foreach ($row as $k => $v) {
                if ($unitofwork->exists($v['id'] . "_" . $this->entity->table)) {
                    $entity = $unitofwork->get($v['id'] . "_" . $this->entity->table);
                    foreach ($this->set as $col => $val) {
                        if ($entity->$col != $val) {
                            $entity->$col = $val;
                        }
                    }
                }
                $in[] = $v['id'];
            }
        foreach ($this->set as $col => $val) {
            $set[] = "$col = '" . $val . "'";
        }
        $where = " id in (" . implode(',', $in) . ")";
        $sql = "update " . $this->entity->table . ' set ' . implode(',', $set) . (($where) ? " where $where" : '');
        $num = Simple_Db_Mysql::getInstance()->query($sql);
        return $num;
    }
}
?>
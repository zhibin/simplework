<?php
class Simple_Db_Join
{
    public $entitys = array();
    public $map;
    public $from;
    public $join;
    public $on;
    public function __construct($entitys = array())
    {
        foreach ($entitys as $k => $v) {
            $this->entitys[$v] = new $v();
        }
    }
    public static function create($entitys = array())
    {
        return new self($entitys);
    }
    public function select($select)
    {
        if (! empty($select)) {
            $select_arr = explode(",", $select);
            foreach ($select_arr as $k => $v) {
                $as_arr = explode("as", $v); //t1.id as a
                $cloumn_arr = explode(".", $as_arr[0]); //t1.id
                $map[trim($as_arr[1])]['name'] = $cloumn_arr[0];
                $map[trim($as_arr[1])]['cloumn'] = $cloumn_arr[1];
            }
        }
        $this->map = $map;
        print_r($map);
        return $this;
    }
    public function fromto($from)
    {
        $this->from = $from;
        return $this;
    }
    public function join($join)
    {
        $this->join = $join;
        return $this;
    }
    public function on($on)
    {
        $this->on = $on;
        return $this;
    }
    public function where($where)
    {}
    public function end()
    {
        $sql = "select ";
        $from = $this->from;
        $join = $this->join;
        $on = $this->on;
        foreach ($this->entitys as $k => $v) {
            foreach ($this->map as $m => $value) {
                if ($value['name'] == $k) {
                    $this->map[$m]['table'] = $v->table;
                    $this->map[$m]['entity'] = $v;
                    $select_cloumn = $v->table . "." . $value['cloumn'];
                    $this->map[$m]['select'] = $select_cloumn;
                    $select_arr[] = $select_cloumn . " as " . $m;
                }
            }
            $from = str_replace($k, $v->table, $from);
            $join = str_replace($k, $v->table, $join);
            $on = str_replace($k, $v->table, $on);
        }
        $select = implode(",", $select_arr);
        print_r($this->map);
        $sql .= $select;
        $sql .= " from " . $from;
        $sql .= " left join " . $join;
        $sql .= " on " . $on;
        echo $sql;
        $row = Simple_Db_Mysql::getInstance()->fetchAll($sql);
        return $this;
        print_r($row);
    }
}
?>
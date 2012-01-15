<?php
class Simple_Db_Join
{
    public $entitys = array();
    public $entity_map = array();
    public $map;
    public $from;
    public $join;
    public $on;
    public $row;
    public $entity_row = array();
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
                $map[trim($as_arr[1])]['name'] = trim($cloumn_arr[0]);
                $map[trim($as_arr[1])]['cloumn'] = trim($cloumn_arr[1]);
            }
        }
        $this->map = $map;
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
            $this->entity_map[$k][] = 'id';
            $this->map[$k . '_id']['name'] = $k;
            $this->map[$k . '_id']['cloumn'] = 'id';
            $this->map[$k . '_id']['entity'] = $v;
            $this->map[$k . '_id']['select'] = $v->table . ".id";
            $select_arr[] = $v->table . ".id" . " as " . $k . '_id';
            $this->entity_map[$k][] = 'version';
            $this->map[$k . '_version']['name'] = $k;
            $this->map[$k . '_version']['cloumn'] = 'version';
            $this->map[$k . '_version']['entity'] = $v;
            $this->map[$k . '_version']['select'] = $v->table . ".version";
            $select_arr[] = $v->table . ".version" . " as " . $k . '_version';
            $from = str_replace($k, $v->table, $from);
            $join = str_replace($k, $v->table, $join);
            $on = str_replace($k, $v->table, $on);
        }
        $select = implode(",", $select_arr);
        $sql .= $select;
        $sql .= " from " . $from;
        $sql .= " left join " . $join;
        $sql .= " on " . $on;
        $row = Simple_Db_Mysql::getInstance()->fetchAll($sql);
        $this->row = $row;
        $this->joinToEntity($row);
        return $this;
    }
    public function joinToEntity()
    {
        if (! empty($this->row))
            foreach ($this->row as $k => $v) {
                foreach ($v as $kk => $vv) {
                    $map = $this->map[$kk];
                    $name = $map['name'];
                    $entity = $map['entity'];
                    $id = $v[$name . "_id"];
                    $version = $v[$name . "_version"];
                    $entity = $entity->buildByIndex($id, $version);
                    $cloumn = $map['cloumn'];
                    if ($entity->exists($cloumn)) {
                        $this->row[$k][$kk] = $entity->$cloumn;
                    } else {
                        $entity->setRow($cloumn, $vv);
                    }
                    if (array_key_exists($name, $this->entity_map) && empty($this->entity_row[$name][$k])) {
                        $this->entity_row[$name][$k] = $entity;
                    }
                }
            }
    }
    public function fetchAllRow()
    {
        return $this->row;
    }
    public function filterEntity($name)
    {
        return $this->entity_row[$name];
    }
}
?>
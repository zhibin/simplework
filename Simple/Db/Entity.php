<?php
class Simple_Db_Entity
{
    private $row;
    private $key;
    private $iscreate = false;
    private $isdelete = false;
    private $updatestack = array();
    protected $default_select_column = array();
    public function __construct()
    {}
    public function getKey()
    {
        return $this->key;
    }
    public function setKey($id)
    {
        $this->key = $id . '_' . $this->table;
        return $this->key;
    }
    public function getByIndex($id)
    {
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $key = $id . "_" . $this->table;
        $entity = $unitofwork->get($key);
        if (empty($entity)) {
            $sql = $this->getSelectSql("id =$id");
            $row = $unitofwork->db->fetch($sql);
            if (! empty($row)) {
                $this->setKey($row['id']);
                $this->row = $row;
                $unitofwork->register($this);
                return $this;
            }
            return $this;
        }
        return $entity;
    }
    public function isEmpty()
    {
        if (empty($this->key) || $this->isdelete)
            return true; else
            return false;
    }
    public function getOne($where = "", $bind = array())
    {
        
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $sql = $this->getSelectSql($where);
        $row = $unitofwork->db->fetch($sql, $bind);
        if (! empty($row)) {
            $entity = $unitofwork->get($this->setKey($row['id']));
            if (empty($entity)) {
                $this->row = $row;
                $unitofwork->register($this);
                return $this;
            }
            return $entity;
        }
        return $this;
    }
    public function getAll($where = "", $bind = array())
    {
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $sql = $this->getSelectSql($where);
        $rows = $unitofwork->db->fetchAll($sql, $bind);
        if (! empty($rows)) {
            $entitys = array();
            foreach ($rows as $k => $row) {
                $key = $row['id'] . "_" . $this->table;
                $entity = $unitofwork->get($key);
                if (empty($entity)) {
                    $this->setKey($row['id']);
                    $this->row = $row;
                    $unitofwork->register($this);
                    $entity = $this;
                }
                $entitys[] = $entity;
            }
        }
        return $entitys;
    }
    public function create($row)
    {
        if (empty($row)) {
            throw new Simple_Exception("create emtity row");
        }
        $id = Simple_Db_Generator::getInstance()->getNextID();
        foreach ($row as $k => $v) {
            $row[$k] = $v;
        }
        $row['id'] = $id;
        $row['version'] = 1;
        $this->iscreate = true;
        $this->row = $row;
        $this->setKey($id);
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $unitofwork->register($this);
        return $this;
    }
    public function __set($name, $value)
    {
        if (in_array($name, $this->column) && ! $this->isdelete) {
            if ($this->row[$name] !== $value) {
                $this->row[$name] = $value;
                if (! $this->iscreate) {
                    // $this->updatestack['id'] = $this->row['id'];
                    $this->updatestack[$name] = $value;
                }
            }
        }
    }
    public function __get($name)
    {
        if ($this->isdelete) {
            return '';
        }
        if (in_array($name, $this->column)) {
            if ($this->row[$name] === null) {
                $this->default_select_column = array('id', 'version', $name);
                $sql = $this->getSelectSql("id = {$this->row['id']}");
                $unitofwork = Simple_Db_Unitofwork::getInstance();
                $row = $unitofwork->db->fetch($sql);
                if(empty($row) || $row['version'] > $this->row['version'])
                {
                    throw  new Simple_Exception("unitofwork not _get select not success! version check clash",1);
                }
                $this->row[$name] = $row[$name];
                return $this->row[$name];
            } else {
                return $this->row[$name];
            }
        } else {
            $map = $this->getJoinMap();
            if (array_key_exists($name, $map)) {
                $entity = $map[$name]['entity'];
                $param = $map[$name]['param'];
                $relation = new $entity();
                $relation = $relation->getByIndex($this->$param);
                return $relation;
            }
            //			else if(array_key_exists($name , $sql)) select * from aritcle where id =$this->id;
        //			{
        //			    $relation = new $entity();
        //				$relation = $relation->getAll($sql, $bind);
        //				return $relation;
        //			}
        }
        return '';
    }
    public function getSelectSql($where)
    {
        $default_select_column = $this->default_select_column;
        if(empty($default_select_column))
        {
            $select_column = "*";
        }
        else
        {
            if(!in_array("id", $default_select_column))
            {
                $default_select_column[] = 'id';
            }
            if(!in_array('version', $default_select_column))
            {
                 $default_select_column[] = 'version';
            }
            $select_column = implode(',', $default_select_column);
        }
        $sql = "select $select_column from {$this->table} where 1=1 and  $where";
        return $sql;
    }
    public function getInsertSql()
    {
        if ($this->iscreate && ! $this->isdelete) {
            $set = array();
            $vals = array();
            foreach ($this->row as $col => $val) {
                if (in_array($col, $this->column)) {
                    $set[] = "`{$col}`";
                    $vals[] = "'" . $val . "'";
                }
            }
            $sql = "insert into " . $this->table . ' (' . implode(', ', $set) . ') ' . 'values (' . implode(', ', $vals) . ')';
            return $sql;
        }
    }
    public function delete()
    {
        $this->isdelete = true;
    }
    public function getDeleteSql()
    {
        if ($this->deletestack) {
            $where = "id='" . $this->row['id'] . "' and ";
            $version = $this->row['version'] + 1;
            $where .= " version <'" . $version . "'";
            $sql = "delete from {$this->table}  where $where";
            return $sql;
        }
    }
    public function getUpdateSql()
    {
        if (! empty($this->updatestack) && ! $this->isdelete) {
            $where = "id='" . $this->row['id'] . "' and ";
            $version = $this->row['version'] + 1;
            $where .= " version <'" . $version . "'";
            $set = array();
            $set[] = "version = '" . ($this->row['version'] + 1) . "'";
            foreach ($this->updatestack as $col => $val) {
                if (in_array($col, $this->column)) {
                    $set[] = "$col = '" . $val . "'";
                }
            }
            $sql = "update " . $this->table . ' set ' . implode(',', $set) . (($where) ? " where $where" : '');
            return $sql;
        }
    }
    public function getJoinMap()
    {
        return array();
    }
}
?>
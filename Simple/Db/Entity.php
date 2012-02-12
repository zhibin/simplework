<?php
class Simple_Db_Entity
{
    private $row;
    private $key;
    public $iscreate = false;
    public $isdelete = false;
    public $updatestack = array();
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
    public function buildByIndex($id, $version)
    {
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $key = $id . "_" . $this->table;
        $entity = $unitofwork->get($key);
        if (empty($entity)) {
            $name = get_class($this);
            $entity = new $name();
            $entity->setKey($id);
            $entity->row['id'] = $id;
            $entity->row['version'] = $version;
            $unitofwork->register($entity);
            return $entity;
        }
        return $entity;
    }
    public function exists($name)
    {
        if ($this->row[$name] === null)
            return false; else
            return true;
    }
    public function setRow($name, $value)
    {
        $this->row[$name] = $value;
    }
    public function getByIndex($id)
    {
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        $key = $id . "_" . $this->table;
        if (! $unitofwork->exists($key)) {
            $sql = $this->getSelectSql("id =$id");
            $row = $unitofwork->db->fetch($sql);
            if (! empty($row)) {
                $this->setKey($row['id']);
                $this->row = $row;
                $unitofwork->register($this);
                return $this;
            }
            return $this;
        } else {
            $entity = $unitofwork->get($key);
            return $entity;
        }
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
            $key = $row['id'] . '_' . $this->table;
            if (! $unitofwork->exists($key)) {
                $this->row = $row;
                $unitofwork->register($this);
                $this->setKey($row['id']);
                return $this;
            } else {
                $entity = $unitofwork->get($key);
                $config = Zend_Registry::get("config");
                if ($config->unitofwork == 'strict') {
                    if ($row['version'] > $entity->row['version']) {
                        throw new Simple_Exception("unitofwork not getOne select  empty not success! version check clash", 1);
                    }
                }
                return $entity;
            }
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
                if (! $unitofwork->exists($key)) {
                    $this->setKey($row['id']);
                    $this->row = $row;
                    $entity = clone $this;
                    $unitofwork->register($entity);
                } else {
                    $entity = $unitofwork->get($key);
                    $config = Zend_Registry::get("config");
                    if ($config->unitofwork == 'strict') {
                        if ($row['version'] > $entity->row['version']) {
                            throw new Simple_Exception("unitofwork not getOne select  empty not success! version check clash", 1);
                        }
                    }
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
        if (! $unitofwork->existsTree(get_class($this), $this->id)) {
            $unitofwork->setTree(get_class($this), $this);
        }
        return $this;
    }
    public function __set($name, $value)
    {
        if (! $this->isdelete) {
            if ($this->row[$name] !== $value) {
                $this->row[$name] = $value;
                if (! $this->iscreate && in_array($name, $this->column)) {
                    $this->updatestack[$name] = $value;
                    $unitofwork = Simple_Db_Unitofwork::getInstance();
                    if (! $unitofwork->existsTree(get_class($this), $this->id)) {
                        $unitofwork->setTree(get_class($this), $this);
                    }
                }
            }
        }
    }
    public function __get($name)
    {
        if ($this->isdelete) {
            return null;
        }
        if (in_array($name, $this->column)) {
            if ($this->row[$name] === null) {
                $this->default_select_column = array('id' , 'version' , $name);
                $sql = $this->getSelectSql("id = {$this->row['id']}");
                $unitofwork = Simple_Db_Unitofwork::getInstance();
                $row = $unitofwork->db->fetch($sql);
                $config = Zend_Registry::get("config");
                if ($config->unitofwork == 'strict') {
                    if (empty($row)) {
                        throw new Simple_Exception("unitofwork not _get select  empty not success! version check clash", 1);
                    } else {
                        if ($row['version'] > $this->row['version']) {
                            throw new Simple_Exception("unitofwork not _get select  version not success! version check clash", 1);
                        }
                    }
                }
                $this->row[$name] = $row[$name];
                return $this->row[$name];
            } else {
                return $this->row[$name];
            }
        } else {
            $map = $this->beLongToMap();
            if (array_key_exists($name, $map)) {
                $entity = $map[$name]['entity'];
                $param = $map[$name]['param'];
                $relation = new $entity();
                $relation = $relation->getByIndex($this->$param);
                return $relation;
            } else {
                return $this->row[$name];
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
        if (empty($default_select_column)) {
            $select_column = "*";
        } else {
            if (! in_array("id", $default_select_column)) {
                $default_select_column[] = 'id';
            }
            if (! in_array('version', $default_select_column)) {
                $default_select_column[] = 'version';
            }
            $select_column = implode(',', $default_select_column);
        }
        $sql = "select $select_column from {$this->table}" . (($where) ? " where  $where" : '');
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
                    $vals[] = "'" . $this->daddslashes($val) . "'";
                }
            }
            $sql = "insert into " . $this->table . ' (' . implode(', ', $set) . ') ' . 'values (' . implode(', ', $vals) . ')';
            return $sql;
        }
    }
    public function  daddslashes($string) 
    {
		if(is_array($string)) 
		{
			foreach($string as $key => $val) 
			{
				$string[$key] = daddslashes($val);
			}
		} 
		else 
		{
			$string = addslashes($string);
		}
    	return $string;
    }
    public function delete()
    {
        $this->isdelete = true;
        $unitofwork = Simple_Db_Unitofwork::getInstance();
        if (! $unitofwork->existsTree(get_class($this), $this->id)) {
            $unitofwork->setTree(get_class($this), $this);
        }
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
                    $set[] = "$col = '" . $this->daddslashes($val) . "'";
                }
            }
            $sql = "update " . $this->table . ' set ' . implode(',', $set) . (($where) ? " where $where" : '');
            return $sql;
        }
    }
    public function beLongToMap()
    {
        return array();
    }
}
?>
<?php
class Simple_Work
{
    public static $work;
    protected $obj;
    protected function __get($key)
    {
        return $this->obj[$key];
    }
    protected function __set($key, $value)
    {
        $this->obj[$key] = $value;
    }
    public function __construct()
    {
        if(self::$work != null)
        {
            throw new Simple_Exception("please call loader");
        }
        $depends = $this->depend();
        if (! empty($depends)) {
            foreach ($depends as $k => $v) {
                if (! class_exists($v)) {
                    throw new Simple_Exception("work not exists");
                }
                if (! $this->work[$k]) {
                    $obj = new $v();
                    $work = $obj->loader();
                    $this->$k = $work;
                }
            }
        }
    }
    public function depend()
    {
        
    }
}
?>
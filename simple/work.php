<?php
class Simple_Work
{
    protected  $work;
    protected function __get($key)
    {
        return $this->work[$key];
    }
    protected function __set($key,  $value)
    {
        $this->work[$key] = $value;
    }
    public function __construct()
    {
        $depends = $this->depend();
        if (! empty($depends)) {
            foreach ($depends as $k => $v) {
                if (! class_exists($v)) {
                    throw new Simple_Exception("work not exists");
                }
                $obj = new $v();
                $work = $obj->loader();
                $this->$k = $work;
            }
        }
    }
}
?>
<?php
 class Simple_Work
 {
  
  public function __construct()
  {
        $depends = $this->depend();
        if (! empty($depends)) {
            foreach ($depends as $k => $v) {
                if (! class_exists($v)) {
                    throw new Simple_Exception("work not exists");
                }
            }
        }
    }
   public function depend()
   {
       
   }
 }


?>
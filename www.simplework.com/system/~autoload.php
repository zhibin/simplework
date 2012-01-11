<?php
    function simple_autoload($classname) {
        $classname = strtolower($classname);
        static $classpath = array(
          'users' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/users.php',
        );
        if (!empty($classpath[$classname])) {
            include_once($classpath[$classname]);
        }
    }
?>
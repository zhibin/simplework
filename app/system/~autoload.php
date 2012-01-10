<?php
    function simple_autoload($classname) {
        $classname = strtolower($classname);
        static $classpath = array(
          'usersentity' => 'D:\project\php\simplework\webroot/../app/entity/users.php',
        );
        if (!empty($classpath[$classname])) {
            include_once($classpath[$classname]);
        }
    }
?>
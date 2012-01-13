<?php
    function simple_autoload($classname) {
        $classname = strtolower($classname);
        static $classpath = array(
          'articles' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/articles.php',
          'directorys' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/directorys.php',
          'users' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/users.php',
        );
        if (!empty($classpath[$classname])) {
            include_once($classpath[$classname]);
        }
    }
?>
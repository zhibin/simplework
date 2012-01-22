<?php
    function simple_autoload($classname) {
        $classname = strtolower($classname);
        static $classpath = array(
          'articles' => 'D:\project\simplework\webroot/../www.simplework.com/entity/articles.php',
          'categorys' => 'D:\project\simplework\webroot/../www.simplework.com/entity/categorys.php',
          'directorys' => 'D:\project\simplework\webroot/../www.simplework.com/entity/directorys.php',
          'users' => 'D:\project\simplework\webroot/../www.simplework.com/entity/users.php',
          'categoryservice' => 'D:\project\simplework\webroot/../www.simplework.com/service/category.service.php',
        );
        if (!empty($classpath[$classname])) {
            include_once($classpath[$classname]);
        }
    }
?>
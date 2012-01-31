<?php
    function simple_autoload($classname) {
        $classname = strtolower($classname);
        static $classpath = array(
          'articles' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/entity/articles.php',
          'categorys' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/entity/categorys.php',
          'directorys' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/entity/directorys.php',
          'mogujies' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/entity/mogujies.php',
          'mogujieusers' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/entity/mogujieusers.php',
          'users' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/entity/users.php',
          'categoryservice' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/service/category.service.php',
          'simple_html_dom_node' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/service/simple_html_dom.php',
          'simple_html_dom' => 'D:\project\php\simplework\www.simplework.com\cron/../../www.simplework.com/service/simple_html_dom.php',
        );
        if (!empty($classpath[$classname])) {
            include_once($classpath[$classname]);
        }
    }
?>
<?php
    function simple_autoload($classname) {
        $classname = strtolower($classname);
        static $classpath = array(
          'albums' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/albums.php',
          'articles' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/articles.php',
          'categorys' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/categorys.php',
          'directorys' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/directorys.php',
          'imagewalls' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/imagewalls.php',
          'mogujiecomments' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/mogujiecomments.php',
          'mogujies' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/mogujies.php',
          'mogujieusers' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/mogujieusers.php',
          'qqusers' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/qqusers.php',
          'sinausers' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/sinausers.php',
          'users' => 'D:\project\php\simplework\webroot/../www.simplework.com/entity/users.php',
          'categoryservice' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/category.service.php',
          'mbapiclient' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/qq/api_client.php',
          'mbopentoauth' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/qq/opent.php',
          'simple_html_dom_node' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/simple_html_dom.php',
          'simple_html_dom' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/simple_html_dom.php',
          'oauthexception' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthconsumer' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthtoken' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthsignaturemethod' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthsignaturemethod_hmac_sha1' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthsignaturemethod_plaintext' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthsignaturemethod_rsa_sha1' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthrequest' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthserver' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthdatastore' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'oauthutil' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'weiboclient' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'weibooauth' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/sina/weibooauth.php',
          'weibosservice' => 'D:\project\php\simplework\webroot/../www.simplework.com/service/weibos.service.php',
        );
        if (!empty($classpath[$classname])) {
            include_once($classpath[$classname]);
        }
    }
?>
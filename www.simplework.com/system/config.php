<?php
return array(
"app_dir"=>"app",
"autoload_file"=>"system/~autoload.php",
"autoload_dirs"=>array("entity", "lib"),
"plugin_dir"=>"plugin",
"home_page"=>array("app"=>"index","controller"=>"index", "action"=>"index"),
"error_page"=>array("app"=>"index","controller"=>"index", "action"=>"error"),
"database"=>array("type"=>"Pdo_Mysql",
                   		"db"=>array("master"=>array("db_host"=>"127.0.0.1",
                                                    "db_user"=>"root",
                                                    "db_pass"=>"",
                                                    "db_name"=>"test",
                                                    "db_character"=>"utf-8",
                                                    "db_percent"=>0),
                   					"slave0"=>array("db_host"=>"127.0.0.1",
                                                    "db_user"=>"root",
                                                    "db_pass"=>"",
                                                    "db_name"=>"test",
                                                    "db_character"=>"utf-8",
                                                    "db_percent"=>60),
									"slave1"=>array("db_host"=>"127.0.0.1",
                                                    "db_user"=>"root",
                                                    "db_pass"=>"",
                                                    "db_name"=>"test",
                                                    "db_character"=>"utf-8",
                                                    "db_percent"=>40)
                                                    )

                    ),

"app"=>array("index"=>array(
                             "error_page"=>array("app"=>"index","controller"=>"index", "action"=>"error1"),
                             "router"=>"Simple_Router",
                     ),
                    
			  "admin"=>array(
                     
                     )
           )
);
?>
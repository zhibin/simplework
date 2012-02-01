<?php
return array(
"app_dir"=>"app",
"autoload_file"=>"system/~autoload.php",
"autoload_dirs"=>array("entity","service"),
"plugin_dir"=>"plugin",
"home_page"=>array("app"=>"index","controller"=>"index", "action"=>"index"),
"error_page"=>array("app"=>"error","controller"=>"error", "action"=>"error"),
"unitofwork"=>"strict",
"database"=>array("type"=>"Mysqli",
                   		"db"=>array("master"=>array("db_host"=>"127.0.0.1",
                                                    "db_user"=>"root",
                                                    "db_pass"=>"",
                                                    "db_name"=>"simplework",
                                                    "db_charset"=>"utf8",
                                                    "db_percent"=>0),
                   					"slave0"=>array("db_host"=>"127.0.0.1",
                                                    "db_user"=>"root",
                                                    "db_pass"=>"",
                                                    "db_name"=>"simplework",
                                                    "db_charset"=>"utf8",
                                                    "db_percent"=>60),
									"slave1"=>array("db_host"=>"127.0.0.1",
                                                    "db_user"=>"root",
                                                    "db_pass"=>"",
                                                    "db_name"=>"simplework",
                                                    "db_charset"=>"utf8",
                                                    "db_percent"=>40)
                                                    )

                    ),

"app"=>array("index"=>array(
                             "error_page"=>array("app"=>"index","controller"=>"index", "action"=>"error1"),
                             "router"=>"Regex_Router",
                     ),
                    
			  "admin"=>array(
                       "router"=>"Regex_Router",
                     )
           ),
           
"regex_router"=>array("index"=>regex_router_app("regex_index.php"),
                      "admin"=>regex_router_app("regex_admin.php"),
                      )           
);
function regex_router_app($regex_app)
{
    return require_once  $regex_app;
}
?>
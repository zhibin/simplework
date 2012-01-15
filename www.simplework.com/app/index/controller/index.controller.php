<?php
class IndexController extends Simple_Controller
{
    public function IndexAction()
    {
        $layout = $this->response->setLayout("helper.layout.htm", $this->map['app']);
        $layout->name = "hello";
        $layout->header = $this->response->dispatch(array("app" => "index" , "controller" => "index" , "action" => "abc"));
        echo $layout->getUrl(array("index" , "index" , "def" , array("d" => 1)));
        echo $this->request->getHost();
        $simple_db = Simple_Db_Mysql::getInstance();
        //$sql = "select * from books_author";
        // $row = $simple_db->fetchAll($sql);
        //    print_r($row);
        $layout->render();
        $row['password'] = "123456";
        $a = Users::getById(109870);
        $b= Users::getByName("rrrrrrr");
        echo $a->password;
        $a->password = "33333333";
        
        $b = Articles::getById("100020");
        $b->title = "bbbbbbbbbb";
         $join = Simple_Db_Join::create(array("Articles", "Directorys"))
         ->select("Articles.id as a , Articles.title as title, Directorys.id as b")
         ->fromto("Articles")
         ->join("Directorys")
         ->on("Articles.directoryid = Directorys.id")
         ->end();
        //$b->status=3 ; 
        $row = $join->fetchAllRow();
        print_r($join->filterEntity('Articles'));
        
        print_r($row);
        Simple_Db_Unitofwork::getInstance()->commit();
    }
    public function DefAction()
    {
        $this->response->bbb = "bbb";
        $this->response->render("/");
    }
    public function AbcAction()
    {
        //        $this->response->header("Location", "http://www.sina.com.cn");
        $this->response->bbb = "dddddddddddddd";
    }
    public function BcdAction()
    {
        /*
		$layout= $this->response->setLayout("helper.layout.htm");  
		$layout->header = $this->dispatch->dispatchApp(
				array("app"=>"index", "controller"=>"index", "action"=>"def")	
			);
		$layout->name = "123";

		$layout->render();
		 */
        //        $this->response->jump( "http://www.baidu.com");
        $this->response->name = "555";
    }
    public function errorAction()
    {
        echo "this is error page";
        exit();
    }
}
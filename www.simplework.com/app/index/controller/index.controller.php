<?php
class IndexController extends Simple_Controller
{
    public function IndexAction()
    {
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
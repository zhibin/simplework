<?php
class IndexController extends Simple_Controller
{
    public function IndexAction()
    {
        $layout = $this->response->setLayout("helper.layout.htm", $this->map['app']);
        $layout->name = "hello";
        $layout->header = $this->dispatch->app(array("app" => "index" , "controller" => "index" , "action" => "abc"));
        echo $layout->getUrl(array("index" , "index" , "def" , array("d" => 1)));
        $layout->render();
    }
    public function DefLayout()
    {
        $this->response->bbb = "bbb";
        $this->response->render("/");
    }
    public function AbcLayout()
    {
        $this->response->bbb = "dddddddddddddd";
    }
    public function BcdLayout()
    {
        /*
		$layout= $this->response->setLayout("helper.layout.htm");  
		$layout->header = $this->dispatch->dispatchApp(
				array("app"=>"index", "controller"=>"index", "action"=>"def")	
			);
		$layout->name = "123";

		$layout->render();
		 */
        $this->response->name = "2wzb";
    }
}
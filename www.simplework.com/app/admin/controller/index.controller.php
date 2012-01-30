<?php
class IndexController extends Simple_Controller 
{
	public function indexAction()
	{
		
	}
	public function loginAction()
	{
		$this->response->msg = $this->request->msg;
	}
	public function loginsubmitAction()
	{
		if($this->request->username=="admin" && $this->request->password == "123456")
		{
			session_start();
			$_SESSION['admin'] = "admin";
			$url = $this->response->url(array("admin","index","index"));
			$this->response->header("Location", $url);
		}
		else 
		{
			$url = $this->response->url(array("admin","index","login",array("msg"=>"用户不存在")));			$this->response->header("Location", $url);
		}
	}
	public function headerAction()
	{
		
	}
	public function menuAction()
	{
		
	}
	public function mainAction()
	{
		echo phpinfo();
	}
	public function logoutAction()
	{
		session_start();
		unset($_SESSION['admin']);
		$this->response->jump($this->response->url(array("admin","index","login")));
	}
}
?>
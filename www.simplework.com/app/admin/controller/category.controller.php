<?php
class CategoryController extends Simple_Controller 
{
	public function init()
	{
		$this->response->type = $this->request->type;
		$this->response->info = $this->request->info;
	}
	public function listAction()
	{
		
		$category_option = categoryService::show(0);
		$this->response->category_option = $category_option;
		$category_tr = categoryService::show(0,"tr");
		$this->response->category_tr = $category_tr;
	}
	public function addAction()
	{
		
	}
	public function addsubmitAction()
	{
		$name = $this->request->name;
		$fid = $this->request->fid;
		categoryService::add($fid, $name);
		$this->response->header("Location",$this->response->url(array("admin", "category","list",array("type"=>"success","info"=>"栏目添加成功"))));
	
	}
}
?>
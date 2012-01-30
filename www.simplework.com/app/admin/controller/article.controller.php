<?php
class ArticleController extends Simple_Controller 
{
	public function init()
	{
		$this->response->type = $this->request->type;
		$this->response->info = $this->request->info;
	}
	public function listAction()
	{
		$articles = Articles::getByAll();
		$this->response->articles = $articles;
	}
	public function addAction()
	{
		$FCKeditor =  new Simple_Tool_FCKeditor('content');
		$this->response->FCKeditor = $FCKeditor;
		
		$category_option = categoryService::show(0);
		$this->response->category_option = $category_option;
	}
	public function addsubmitAction()
	{
		$title = $this->request->title;
		$fromto = $this->request->fromto;
		$categoryid = $this->request->categoryid;
		$content = $this->request->content;
		$row['title'] = $title;
		$row['fromto'] = $fromto;
		$row['categoryid'] = $categoryid;
		$row['content'] = $content;
		Articles::createBy($row);
		$this->response->header("Location",$this->response->url(array("admin", "article","add",array("type"=>"success","info"=>"文章添加成功,继续添加"))));
	}
	public function modifyAction()
	{
		$article_id = $this->request->id;
		
		$article = Articles::getById($article_id);
		$this->response->article = $article;
		
		
		$category_option = categoryService::show(0, "option", $article->categoryid);
		$this->response->category_option = $category_option;
		
		
		$FCKeditor =  new Simple_Tool_FCKeditor('content');
		$FCKeditor->Value = $article->content;
		$this->response->FCKeditor = $FCKeditor;
		
	}
	public function modifysubmitAction()
	{
		$article_id = $this->request->id;
		$article = Articles::getById($article_id);
		$title = $this->request->title;
		$fromto = $this->request->fromto;
		$categoryid = $this->request->categoryid;
		$content = $this->request->content;
		$article->title = $title;
		$article->fromto = $fromto;
		$article->categoryid = $categoryid;
		$article->content = $content;
		$article->mtime = time();
		$this->response->header("Location",$this->response->url(array("admin", "article","list",array("type"=>"success","info"=>"文章修改成功"))));
	}
}
?>
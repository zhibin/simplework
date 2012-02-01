<?php
class IndexController extends Simple_Controller
{
    public function IndexAction()
    {
        echo $this->response->url(array("index","index","index",array("id"=>123,"b"=>'abc'),array('c'=>1)));
        exit;
    }
    public function ShoppingAction()
    {
        
    }
}
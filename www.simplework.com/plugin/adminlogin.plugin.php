<?php
class AdminloginPlugin extends Simple_Plugin 
{
    public function dispatchLoopStartup($map)
    {
    	if($map['app']=='admin' && $map['action']!= 'login' && $map['action'] != 'loginsubmit') 
    	{
    		session_start();
	        if(empty($_SESSION['admin']))
	        {
	        	$url = $this->response->url(array("admin","index","login"));
	        	$this->response->jump($url);
	        }
    	}
    }
}
?>
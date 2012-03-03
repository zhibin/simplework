<?php
class UserloginPlugin extends Simple_Plugin 
{
    public function routeStartup()
    {
        
    }
    public function routeShutdown($map)
    {
       
    }
    public function dispatchLoopStartup($map)
    {
        session_start();
        if($map['app'] == 'index' || $map['app'] == 'user')
        {
            if(!empty($_SESSION['site']['userid']))
            {
               $loginuser = Users::getById($_SESSION['site']['userid']);
               $this->response->setContext("loginuser", $loginuser);
            }
        }
    }
    public function preDispatch($map)
    {
        
    }
    public function postDispatch($map)
    {
        
    }
    public function dispatchLoopShutdown($map)
    {
        
    }
}
?>
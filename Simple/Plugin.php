<?php
class Simple_Plugin
{
    public $request;
    public $response;
    public $rewrite;
    public function __construct($request, $response, $rewrite)
    {
        $this->request = $request;
        $this->response = $response;
        $this->rewrite = $rewrite;
    }
    public function routeStartup(){}
    public function routeShutdown($map){}
    public function dispatchLoopStartup($map){}
    public function preDispatch($map){}
    public function postDispatch($map){}
    public function dispatchLoopShutdown($map){}
}
?>
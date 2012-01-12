<?php
class Simple_Controller
{
    public $request;
    public $response;
    public $map;
    public function __construct($map, $request, $response)
    {
        $this->map = $map;
        $this->request = $request;
        $this->response = $response;
        $this->init();
    }
    protected function init()
    {}
    public function end()
    {}
}

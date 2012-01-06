<?php
class Simple_Controller
{
	public $request;
	public $response;
	public $dispatch;
	public $map;
	public function __construct($map, $request, $response, $dispatch)
	{
		$this->map = $map;
		$this->request = $request;
		$this->response = $response;
		$this->dispatch = $dispatch;
		$this->init();
	}

	protected function init()
	{
	}
    public  function end()
    {
    }
}

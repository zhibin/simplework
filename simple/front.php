<?php
class Simple_Front
{
    public $request;
    public $response;
    public $rewrite;
    public static $instance;
    private function __construct()
    {}
    static public function getInstance()
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
            self::$instance->request = new Simple_Request();
            self::$instance->rewrite = new Simple_Rewrite(self::$instance->request);
            self::$instance->response = new Simple_Response();
            self::$instance->dispatch = new Simple_Dispatch(self::$instance->request, self::$instance->response, self::$instance->rewrite);
        }
        return self::$instance;
    }
    public function run()
    {
        try {
            $this->dispatch->start();
        } catch (Simple_Exception $e) {
            echo $e->getMessage();
        }
    }
}

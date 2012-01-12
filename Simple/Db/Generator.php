<?php
class Simple_Db_Generator
{
    const QUEUE_SIZE = 10;
	const END_OF_QUEUE = self::QUEUE_SIZE;
	private $offset;
	private $queue;
	public static $generator;
	private function __construct()
	{	
		$this->queue = array_fill(0, self::QUEUE_SIZE, 0);
		$this->offset = self::END_OF_QUEUE;
	}
	public static function getInstance()
	{
	    if(self::$generator == null)
	    {
	        self::$generator = new self();
	    }
	    return self::$generator;
	}
	public function getNextID()
	{
		if ($this->offset == self::END_OF_QUEUE)
		{
			$this->fillQueueFromDb();
			$this->offset = 0;
		}
		return $this->queue[$this->offset++];
	}
	
	private function fillQueueFromDb()
	{
		$db = Simple_Db_Mysql::getInstance();	
        $queueSize = self::QUEUE_SIZE;
		$db->update("update idgenerator set nextid=LAST_INSERT_ID(nextid+$queueSize)");
		$rowset = $db->db_master->fetch("select LAST_INSERT_ID() as nextid");
		$nextId = $rowset["nextid"];
    	$i = self::END_OF_QUEUE;
    	while ($i > 0)
    	{
    		$this->queue[--$i] = --$nextId;
    	}
	}
}
?>
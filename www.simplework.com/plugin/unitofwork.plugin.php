<?php
class UnitofworkPlugin extends Simple_Plugin 
{
	public function postDispatch($map)
	{
		Simple_Db_Unitofwork::getInstance()->commit();	
	}
}
?>
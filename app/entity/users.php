<?php
class usersEntity  extends Work_Unitofwork_Entity 
{
  
    public static function getUser()
    {
       $users =  new self();
       $users->getEntityById("123");
    }
}
?>
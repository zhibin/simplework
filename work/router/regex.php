<?php
class Work_Router_Regex
{
    public function loader()
    {
        $front = Simple_Front::getInstance();
        $front->rewrite->addRouter("Work_Router_Regex");
    }
}
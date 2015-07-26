<?php

class App_Exception_Forbidden extends Exception
{
    public function __construct()
    {
        parent::__construct("Forbidden", 403);
    }
}
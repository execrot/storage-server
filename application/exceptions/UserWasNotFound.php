<?php

class App_Exception_UserWasNotFound extends Exception
{
    public function __construct()
    {
        parent::__construct("User was not found", 404);
    }
}
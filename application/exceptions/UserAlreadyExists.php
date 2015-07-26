<?php

class App_Exception_UserAlreadyExists extends Exception
{
    public function __construct()
    {
        parent::__construct("User already exists", 422);
    }
}
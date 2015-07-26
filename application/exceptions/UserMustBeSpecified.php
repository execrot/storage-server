<?php

class App_Exception_UserMustBeSpecified extends Exception
{
    public function __construct()
    {
        parent::__construct("User must be specified", 500);
    }
}
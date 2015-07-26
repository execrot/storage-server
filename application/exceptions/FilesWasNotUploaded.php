<?php

class App_Exception_FilesWasNotUploaded extends Exception
{
    public function __construct()
    {
        parent::__construct("File was not uploaded", 400);
    }
}
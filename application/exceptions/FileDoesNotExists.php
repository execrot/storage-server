<?php

class App_Exception_FileDoesNotExists extends \Exception
{
    /**
     * @param string $file
     */
    public function __construct($file)
    {
        parent::__construct("Requested file '{$file}' die not exists");
    }
}
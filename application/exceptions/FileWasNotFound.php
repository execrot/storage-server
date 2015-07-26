<?php

class App_Exception_FileWasNotFound extends \Exception
{
    /**
     * @param string $file
     */
    public function __construct($file)
    {
        parent::__construct("Requested file '{$file}' was not found");
    }
}
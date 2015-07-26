<?php

class App_Exception_FileIsNotReadable extends \Exception
{
    /**
     * @param string $file
     */
    public function __construct($file)
    {
        parent::__construct("Requested file '{$file}' is not readable");
    }
}
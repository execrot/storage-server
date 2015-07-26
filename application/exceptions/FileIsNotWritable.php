<?php

class App_Exception_FileIsNotWritable extends \Exception
{
    /**
     * @param string $file
     */
    public function __construct($file)
    {
        parent::__construct("Requested file '{$file}' is not writable");
    }
}
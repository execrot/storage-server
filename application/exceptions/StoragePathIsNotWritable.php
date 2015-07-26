<?php

class App_Exception_StoragePathIsNotWritable extends \Exception
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct("Storage path '{$path}' is not writable");
    }
}
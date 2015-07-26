<?php

class App_Exception_StoragePathDoesNotExists extends \Exception
{
    /**
     * @param string $path
     */
    public function __construct($path)
    {
        parent::__construct("Storage path '{$path}' does not exists");
    }
}
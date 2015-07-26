<?php

class App_Exception_StoragePathIsNotSpecified extends \Exception
{
    /**
     * Overload exception message
     */
    public function __construct()
    {
        parent::__construct("Storage path is not specified");
    }
}
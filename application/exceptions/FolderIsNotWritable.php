<?php

class App_Exception_FolderIsNotWritable extends \Exception
{
    /**
     * @param string $folder
     */
    public function __construct($folder)
    {
        parent::__construct("Requested folder '{$folder}' is not writable");
    }
}
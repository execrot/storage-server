<?php

class App_Exception_UnableToCopyFile extends \Exception
{
    /**
     * @param string $reason
     */
    public function __construct($reason)
    {
        parent::__construct("Unable to copy file: {$reason}");
    }
}
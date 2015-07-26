<?php

class App_Exception_UnableToSaveFile extends \Exception
{
    /**
     * @param string $reason
     */
    public function __construct($reason)
    {
        parent::__construct("Unable to save file: {$reason}");
    }
}
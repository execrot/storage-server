<?php

class AdapterDoesNotSupportMethod extends Exception
{
    public function __construct($adapterName, $methodName)
    {
        parent::__construct("Adapter {$adapterName} does not support {$methodName} method", 500);
    }
}
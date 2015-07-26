<?php

class App_Map_File extends Mongostar_Map_Instance
{
    /**
     * @return array
     */
    public function rulesCommon()
    {
        return [
            'identity' => 'identity',
            'name' => 'name',
            'type' => 'type',
            'size' => 'size',
            'url' => 'url',
        ];
    }

    /**
     * @return array
     */
    public function rulesSearch()
    {
        return [
            'identity' => 'identity',
            'name' => 'name',
            'type' => 'type',
            'size' => 'size',
            'url' => 'url',
        ];
    }

    /**
     * @param App_Model_File $file
     * @return string
     *
     * @throws App_Exception_Forbidden
     */
    public function getUrl($file)
    {
        $storage = new App_Service_Storage();
        return $storage->getUrl($file);
    }
}
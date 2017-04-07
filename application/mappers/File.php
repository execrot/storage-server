<?php

class App_Map_File extends \MongoStar\Map
{
    /**
     * @return array
     */
    public function common()
    {
        return [
            'identity' => 'identity',
            'name' => 'name',
            'type' => 'type',
            'size' => 'size',
            'url' => 'url',
        ];
    }

    public function upload()
    {
        return [
            'identity' => 'identity',
            'name' => 'name',
            'type' => 'type',
            'size' => 'size',
            'url' => 'url',
            'success' => 'success'
        ];
    }

    /**
     * @return array
     */
    public function search()
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
     * @return string
     *
     * @throws App_Exception_Forbidden
     */
    public function getUrl()
    {
        $storage = new App_Service_Storage();
        return $storage->getUrl($this->getRow());
    }

    /**
     * @param $file
     * @return bool
     */
    public function getSuccess($file)
    {
        if (!empty($this->getUserData()['success'])) {
            return $this->getUserData()['success'];
        }

        return false;
    }
}
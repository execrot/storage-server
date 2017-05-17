<?php

class App_Map_File extends \MongoStar\Map
{
    /**
     * @return array
     */
    public function common() : array
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
     * @param App_Model_File $file
     * @return string
     *
     * @throws App_Exception_Forbidden
     */
    public function getUrl(App_Model_File $file)
    {
        $storage = new App_Service_Storage();
        return $storage->getUrl($file);
    }

    /**
     * @return bool
     */
    public function getSuccess()
    {
        $userData = $this->getUserData();

        if (!empty($userData['success'])) {
            return $userData['success'];
        }

        return false;
    }
}
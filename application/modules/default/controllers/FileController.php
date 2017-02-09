<?php

class FileController extends Default_Controller_Auth
{
    /**
     * @var App_Service_Storage
     */
    public $storage = null;

    /**
     * @throws App_Exception_Forbidden
     */
    public function init()
    {
        parent::init();

        $this->storage = new App_Service_Storage();
    }

    /**
     * Upload
     *  $_FILES
     *
     * @throws App_Exception_FileIsNotReadable
     * @throws App_Exception_FilesWasNotUploaded
     * @throws App_Exception_UnableToCopyFile
     */
    public function uploadAction()
    {
        if (empty($_FILES['files'])) {
            throw new App_Exception_FilesWasNotUploaded();
        }

        $files = array_map(function($name, $type, $tmpName, $error, $size){
            return [
                'name' => $name,
                'type' => $type,
                'tmpName' => $tmpName,
                'error' => $error,
                'size' => $size,
                'identity' => md5(microtime())
            ];

        },  $_FILES['files']['name'],
            $_FILES['files']['type'],
            $_FILES['files']['tmp_name'],
            $_FILES['files']['error'],
            $_FILES['files']['size']
        );

        foreach ($files as $file) {

            $maxUpload = (int)(ini_get('upload_max_filesize'));

            if (($file['size'] * 1024 * 1024) < $maxUpload) {

                $results[] = [
                    'success' => false,
                    'error' => "Exceeded max upload size"
                ];
            }

            $results[] = App_Map_File::execute(
                $this->storage->save($file),
                'upload',
                ['success' => true]
            );
        }

        $this->content = $results;
    }

    /**
     * List
     *  (int)from
     *  (int)count
     */
    public function listAction()
    {
        $this->content = App_Map_File::execute(
            App_Model_File::fetchAll(
                ['user' => (string)$this->user->id],
                null,
                $this->getParam('count'),
                $this->getParam('from')
            )
        );
    }

    /**
     * Total file count
     */
    public function countTotalAction()
    {
        $this->content = [
            'count' => App_Model_File::getCount([
                'user' => (string)$this->user->id
            ])
        ];
    }

    /**
     * Info
     *  (array)ids
     */
    public function infoAction()
    {
        $this->content = [];

        foreach ($this->getParam('ids', []) as $id) {

            $file = App_Model_File::fetchOne([
                'user' => (string)$this->user->id,
                'identity' => $id
            ]);

            $this->content[] = App_Map_File::execute($file, 'search');
        }
    }

    /**
     * Search
     *  (string)query
     */
    public function searchAction()
    {
        $this->content = App_Map_File::execute(
            $file = App_Model_File::fetchAll([
                'user' => (string)$this->user->id,
                'name' => new MongoRegex('/' . $this->getParam('query') . '/')
            ], null, $this->getParam('count', 10), $this->getParam('from', 0))
        );
    }

    /**
     * Delete
     *  (array)ids
     *
     * @throws App_Exception_FileIsNotWritable
     * @throws App_Exception_Forbidden
     */
    public function deleteAction()
    {
        $files = App_Model_File::fetchAll([
            'user' => (string)$this->user->id,
            'identity' => ['$in' => $this->getParam('ids')]
        ]);

        foreach ($files as $file) {
            $this->storage->delete($file);
        }
    }
}
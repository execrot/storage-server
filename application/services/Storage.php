<?php

class App_Service_Storage
{
    /**
     * @var array
     */
    protected static $_config = [];

    /**
     * @var App_Model_User
     */
    protected static $_user = null;

    /**
     * @param array $config
     * 
     * @throws App_Exception_StoragePathDoesNotExists
     * @throws App_Exception_StoragePathIsNotSpecified
     * @throws App_Exception_StoragePathIsNotWritable
     */
    public static function setConfig(array $config = [])
    {
        if (empty($config['path'])) {
            throw new App_Exception_StoragePathIsNotSpecified();
        }

        if (!file_exists($config['path'])) {
            throw new App_Exception_StoragePathDoesNotExists($config['path']);
        }

        if (!is_writable($config['path'])) {
            throw new App_Exception_StoragePathIsNotWritable($config['path']);
        }

        self::$_config = $config;
    }

    /**
     * @param App_Model_User $user
     */
    public static function setUser(App_Model_User $user)
    {
        self::$_user = $user;
    }

    /**
     * @throws App_Exception_UserMustBeSpecified
     */
    public function __construct()
    {
        if (!self::$_user) {
            throw new App_Exception_UserMustBeSpecified();
        }
    }

    /**
     * @param array $file
     *
     * @return App_Model_File|array
     *
     * @throws App_Exception_FileIsNotReadable
     * @throws App_Exception_UnableToCopyFile
     */
    public function save(array $file)
    {
        if (!is_readable($file['tmpName'])) {
            throw new App_Exception_FileIsNotReadable($file['tmpName']);
        }

        $identifier = md5(microtime());

        try {
            $ext = explode('.', $file['name'])[count(explode('.', $file['name']))-1];
            $newFilePath = $this->_getAbsoluteFilePath($identifier, $ext, true);
            copy($file['tmpName'], $newFilePath);
            chmod($newFilePath, 0777);

            $file = new App_Model_File();

            $file->populate([
                'name' => $file['name'],
                'type' => $file['type'],
                'size' => $file['size'],
                'ext'  => $ext,
                'identity' => $identifier,
                'user' => (string)self::$_user->id
            ]);

            $file->save();
        }
        catch(\Exception $e) {
            throw new App_Exception_UnableToCopyFile($e->getMessage());
        }

        return $file;
    }

    /**
     * @param App_Model_File $file
     *
     * @return string
     * 
     * @throws App_Exception_Forbidden
     */
    public function getUrl(App_Model_File $file)
    {
        if ($file->user != (string)self::$_user->id) {
            throw new App_Exception_Forbidden();
        }

        return implode('/', [
            self::$_config['url'],
            $this->_getRelativeFilePath($file->identity, $file->ext)
        ]);
    }

    /**
     * @param App_Model_File $file
     *
     * @return bool
     *
     * @throws App_Exception_FileIsNotWritable
     * @throws App_Exception_Forbidden
     */
    public function delete(App_Model_File $file)
    {
        if ($file->user != (string)self::$_user->id) {
            throw new App_Exception_Forbidden();
        }

        $filePath = $this->_getAbsoluteFilePath($file->identity, $file->ext);
        $res = false;

        if (file_exists($filePath)) {
            if (!is_writable($filePath)) {
                throw new App_Exception_FileIsNotWritable($filePath);
            }
            $res = (bool)unlink($filePath);

            $file->remove();
        }

        try {

            $folderRelativePath = $this->_getRelativeFolderPath($file->identity);

            $path = implode('/', [
                self::$_config['path'],
                $folderRelativePath
            ]);

            $count = count(explode('/', $folderRelativePath));

            for ($i = $count - 1; $i > -1; $i--) {
                rmdir($path);
                $path = dirname($path);
            }
        }
        catch (\Exception $e) {}

        return $res;
    }

    /**
     * @param string $identifier
     * @param bool   $create
     *
     * @return null|string
     * @throws App_Exception_FolderIsNotWritable
     */
    private function _getRelativeFolderPath($identifier, $create = false)
    {
        $nesting = self::$_config['nesting'];
        $step = self::$_config['step'];

        $folder = null;

        for ($i = 0; $i < $nesting; $i++) {

            $folder = implode('/', array_filter([
                $folder,
                substr($identifier, $i*$step, $step)
            ]));

            if ($create) {
                $path = implode('/', [
                    self::$_config['path'],
                    $folder
                ]);

                if (!file_exists($path)) {
                    if (!is_writable(dirname($path))) {
                        throw new App_Exception_FolderIsNotWritable(dirname($path));
                    }

                    mkdir($path);
                    chmod($path, 0777);
                }
            }
        }

        return $folder;
    }

    /**
     * @param string $identifier
     * @param string $ext
     * @param bool   $create
     *
     * @return string
     */
    private function _getRelativeFilePath($identifier, $ext = null, $create = false)
    {
        return implode('/', [
            $this->_getRelativeFolderPath($identifier, $create),
            implode('.', array_filter([$identifier, $ext]))
        ]);
    }

    /**
     * @param string $identifier
     * @param string $ext
     * @param bool   $create
     *
     * @return string
     */
    private function _getAbsoluteFilePath($identifier, $ext = null, $create = false)
    {
        return implode('/', [
            self::$_config['path'],
            $this->_getRelativeFilePath($identifier, $ext, $create)
        ]);
    }
}
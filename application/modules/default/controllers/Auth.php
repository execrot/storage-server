<?php

abstract class Default_Controller_Auth extends Default_Controller_Base
{
    /**
     * @var App_Model_User
     */
    public $user = null;

    /**
     * Authorize user by token
     *
     * @throws App_Exception_Forbidden
     */
    public function init()
    {
        parent::init();

        $this->user = App_Model_User::fetchOne([
            'tokens' => [
                '$in' => [
                    $this->getRequest()->getHeader('x-auth')
                ]
            ]
        ]);

        if (!$this->user) {
            throw new App_Exception_Forbidden();
        }

        $config = Zend_Registry::get('config');

        App_Service_Storage::setConfig($config['storage']);
        App_Service_Storage::setUser($this->user);
    }
}
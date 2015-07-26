<?php

class UserController extends Default_Controller_Base
{
    public function authAction()
    {
        $user = App_Model_User::fetchOne([
            'email' => $this->getParam('email'),
            'password' => $this->getParam('password')
        ]);

        if (!$user) {
            throw new App_Exception_UserWasNotFound();
        }

        $user->addToken();
        $this->content->user = App_Map_User::execute($user);
    }

    public function registerAction()
    {
        $exists = App_Model_User::getCount([
            'email' => $this->getParam('email')
        ]);

        if ($exists) {
            throw new App_Exception_UserAlreadyExists();
        }

        $user = new App_Model_User([
            'email' => $this->getParam('email'),
            'password' => $this->getParam('password'),
            'registered' => time(),
        ]);

        $user->addToken();
        $user->save();
    }
}
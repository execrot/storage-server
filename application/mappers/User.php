<?php

class App_Map_User extends Mongostar_Map_Instance
{
    public function rulesCommon()
    {
        return [
            'id' => 'id',
            'email' => 'email',
            'tokens' => 'tokens'
        ];
    }
}
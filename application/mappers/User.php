<?php

class App_Map_User extends \MongoStar\Map
{
    public function common()
    {
        return [
            'id' => 'id',
            'email' => 'email',
            'tokens' => 'tokens'
        ];
    }
}
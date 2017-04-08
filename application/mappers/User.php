<?php

class App_Map_User extends \MongoStar\Map
{
    /**
     * @return array
     */
    public function common () : array
    {
        return [
            'id' => 'id',
            'email' => 'email',
            'tokens' => 'tokens'
        ];
    }
}
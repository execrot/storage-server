<?php

/**
 * @collection user
 *
 * @property string     $id
 * @property string     $email
 * @property string     $password
 * @property array      $tokens
 * @property int        $registered
 *
 * @method static App_Model_User[] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_User|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_User fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_User extends \MongoStar\Model
{
    /**
     * @param string $email
     * @return bool
     */
    public static function isEmailExists($email)
    {
        return (bool)self::count([
            'email' => $email
        ]);
    }

    /**
     *
     */
    public function addToken()
    {
        $tokens = (is_array($this->tokens))?$this->tokens:[];
        $tokens[] = md5(microtime());
        $this->tokens = $tokens;
        $this->save();
    }
}

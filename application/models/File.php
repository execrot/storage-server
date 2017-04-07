<?php

/**
 * @collection File
 *
 * @property string     $id
 * @property string     $name
 * @property string     $type
 * @property string     $size
 * @property string     $ext
 * @property string     $identity
 * @property string     $user
 *
 * @method static App_Model_File[] fetchAll(array $cond = null, array $sort = null, $count = null, $offset = null, $hint = NULL)
 * @method static App_Model_File|null fetchOne(array $cond = null, array $sort = null)
 * @method static App_Model_File fetchObject(array $cond = null, array $sort = null)
 */
class App_Model_File extends \MongoStar\Model {}
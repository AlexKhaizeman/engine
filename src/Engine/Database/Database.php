<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 01/04/17
 * Time: 00:39
 */

namespace Engine\Database;


use PDO;

class Database
{
    protected $_pdo;

    public function __construct($config)
    {
        $dns = 'mysql:dbname='.$config['database'].";host=".$config['host'] . ';charset=UTF8;';
        $this->_pdo = new PDO( $dns, $config['username'], $config['password'] );
    }
}
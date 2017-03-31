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
    /**
     * @var PDO
     */
    protected $_pdo;

    public function __construct($config)
    {
        $dns = 'mysql:dbname='.$config['database'].";host=".$config['host'] . ';charset=UTF8;';
        $this->_pdo = new PDO( $dns, $config['username'], $config['password'] );
    }

    public function pdo()
    {
        return $this->_pdo;
    }

    public function all($query, $params = [])
    {
        $data = [];
        $stmt = $this->_pdo->prepare($query);
        $stmt->execute($params);
        foreach ($stmt as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get($query, $params = [])
    {
        $data = $this->all($query, $params);
        return isset($data[0]) ? $data[0] : null;
    }
}
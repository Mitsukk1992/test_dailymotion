<?php

namespace Core\Orm;

use Core\Exceptions\OrmConnectionException;

class Orm
{
    private $db;

    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Orm();
        }

        return self::$instance;
    }

    public function connect($host, $user, $password, $database)
    {
        try {
            $this->db = new \PDO("mysql:host=$host;dbname=$database", $user, $password);

        } catch (\PDOException $e) {
            throw new OrmConnectionException($e->getMessage());
        }
    }
}
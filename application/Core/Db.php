<?php

namespace Application\Core;
use PDO;
use PDOException;

class Db
{
    private static $db = null;
    private $pdo;

    public static function getPdo(){
        if(!isset(self::$db)){
            self::$db = new Db();
        }

        return self::$db->pdo;
    }

    private function __construct()
    {
        $options = array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        );
        try {
            $this->pdo = new PDO(
                DB_TYPE .
                ':host=' . DB_HOST .
                ';dbname=' . DB_NAME .
                ';charset=' . DB_CHARSET,
                DB_USER,
                DB_PASS,
                $options
            );
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }
}



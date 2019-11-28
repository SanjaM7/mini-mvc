<?php

namespace Application\Core;
use PDO;
use PDOException;

/**
 * Class Db
 * This class makes singleton connection with database
 * @package Application\Core
 */
class Db
{
    /**
     * @var null
     */
    private static $db = null;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * Restrict the instantiation of a class to a single object
     * @return PDO
     */
    public static function getPdo(){
        if(!isset(self::$db)){
            self::$db = new Db();
        }

        return self::$db->pdo;
    }

    /**
     * Connect to a database with the credentials from config file
     * Db constructor.
     */
    private function __construct()
    {
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        ];
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


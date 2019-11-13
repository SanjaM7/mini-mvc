<?php

namespace Application\Models;

use PDO;
use PDOException;

class Model
{
    protected $table;
    /**
     * @var PDO
     */
    private $db;

    function __construct(string $table)
    {
        try {
            $this->openDatabaseConnection();
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
        $this->table = $table;
    }

    private function openDatabaseConnection()
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING);
        $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PASS, $options);
    }

    public function get($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetchAll();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM " . $this->table;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function count()
    {
        $sql = "SELECT COUNT(id) AS count FROM " . $this->table;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->count;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
    }

    public function add($param)
    {
        $sql = "INSERT INTO " .$this->table;
        $assocArray = get_object_vars($param);
        unset($assocArray['id']);
        unset($assocArray['db']);
        unset($assocArray['table']);

        //"insert into songs (artist, track, link) values (:artist, :track, :link)";
        $keys = array_keys($assocArray);
        $columns = implode(", ", $keys);

        $values = array();
        foreach ($keys as $key){
            $values[":$key"] = $assocArray[$key];
        }

        $valueKeys = array_keys($values);
        $valuesAliases = implode(", ", $valueKeys);
        $sql = "$sql ($columns) values ($valuesAliases)";

        $query = $this->db->prepare($sql);
        $query->execute($values);
        $param->id = $this->db->lastInsertId();
    }
}


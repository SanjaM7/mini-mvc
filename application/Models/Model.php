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
        return $query->fetch();
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
        return $query->rowCount();
    }

    public function save()
    {
        //"insert into songs (artist, track, link) values (:artist, :track, :link)";
        $sql = "INSERT INTO " . $this->table;
        $assocArray = get_object_vars($this);
        unset($assocArray['id']);
        unset($assocArray['db']);
        unset($assocArray['table']);

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
        $this->id = $this->db->lastInsertId();
    }


    public function update()
    {
        //UPDATE songs SET artist = :artist, track = :track, link = :link WHERE id = :id;
        $sql = "UPDATE " . $this->table;
        $id = (int)$this->id;
        $assocArray = get_object_vars($this);
        unset($assocArray['id']);
        unset($assocArray['db']);
        unset($assocArray['table']);

        $keys = array_keys($assocArray);

        $setArgs = array();
        foreach($keys as $key){
            $setArgs[] = "$key = :$key";
        }

        $setStatement = implode(", ", $setArgs);

        $values = array();
        foreach ($keys as $key){
            $values[":$key"] = $assocArray[$key];
        }

        $values[":id"] = $id;
        $sql = "$sql SET $setStatement WHERE id = :id";
        $query = $this->db->prepare($sql);
        $query->execute($values);
        return $query->rowCount();
    }

    public function getWhere($key, $value)
    {
        //SELECT email FROM users WHERE email = :email;
        $sql = "SELECT * FROM $this->table WHERE $key = :$key";
        $query = $this->db->prepare($sql);
        $query->execute($value);
        return $query->fetchAll();
    }

    public function exists($key, $value)
    {
        //SELECT email FROM users WHERE email = :email;
        $sql = "SELECT * FROM $this->table WHERE $key = :$key";
        $query = $this->db->prepare($sql);
        $value = array(
            ":$key" => $value
        );
        $query->execute($value);
        return (bool)$query->fetch();
    }
}


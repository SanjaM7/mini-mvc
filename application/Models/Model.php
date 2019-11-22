<?php

namespace Application\Models;

use PDO;
use PDOException;

abstract class Model
{
    /*** @var PDO */
    public $db;
    public $table;

    function __construct($table)
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
        $options = array(
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        );
        $this->db = new PDO(
            DB_TYPE .
            ':host=' . DB_HOST .
            ';dbname=' . DB_NAME .
            ';charset=' . DB_CHARSET,
            DB_USER,
            DB_PASS,
            $options
        );
    }

    private function doGetWhere($key, $value, $limit)
    {
        //SELECT email FROM users WHERE email = :email (LIMIT 1);
        $sql = "SELECT * FROM $this->table WHERE $key = :$key";
        if($limit > 0){
            $sql = "$sql LIMIT $limit";
        }

        $stmt = $this->db->prepare($sql);
        $params = array(
            ":$key" => $value
        );
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result;
    }

    public function getWhere($key, $value)
    {
        return $this->doGetWhere($key, $value, 0);
    }

    public function getFirstWhere($key, $value)
    {
        $result = $this->doGetWhere($key, $value, 1);
        $first = null;
        if(!empty($result)){
            $first = $result[0];
        }

        return $first;
    }

    public function get($id)
    {
        return $this->getFirstWhere('id', $id);
    }

    public function getAll()
    {
        return $this->getWhere('1', '1');
    }

    public function exists($key, $value)
    {
        $result = $this->getFirstWhere($key, $value);
        return $result !== null ? true : false;
    }

    public function count()
    {
        $sql = "SELECT COUNT(id) AS count FROM $this->table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch()->count;
        return $result;
    }

    public function deleteWhere($id, $key, $value)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id AND $key = :$key";
        $stmt = $this->db->prepare($sql);
        $params = array(
            ':id' => $id,
            ":$key" => $value
        );
        $stmt->execute($params);
        $affectedRows = $stmt->rowCount();
        return $affectedRows;
    }

    public function softDelete($id)
    {
        //UPDATE roles SET deleted = :1 WHERE id = :id AND deleted = :0;
        $sql = "UPDATE $this->table SET deleted = :1 WHERE id = :id AND deleted = :0";
        $stmt = $this->db->prepare($sql);
        $params = array(
            ':1' => 1,
            ':id' => $id,
            ':0' => 0
        );
        $stmt->execute($params);
        $affectedRows = $stmt->rowCount();
        return $affectedRows;
    }

    public function save()
    {
        //"insert into songs (artist, track, link) values (:artist, :track, :link)";
        $sql = "INSERT INTO $this->table";
        $assocArray = get_object_vars($this);
        unset($assocArray['id']);
        unset($assocArray['db']);
        unset($assocArray['table']);

        $keys = array_keys($assocArray);
        $columns = implode(', ', $keys);

        $params = array();
        foreach ($keys as $key){
            $params[":$key"] = $assocArray[$key];
        }
        $paramsKeys = array_keys($params);
        $paramsAliases = implode(', ', $paramsKeys);
        $sql = "$sql ($columns) VALUES ($paramsAliases)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $id = $this->db->lastInsertId();
        $this->id = $id;
    }

    public function update()
    {
        //UPDATE songs SET artist = :artist, track = :track, link = :link WHERE id = :id;
        $sql = "UPDATE $this->table";
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

        $setStatement = implode(', ', $setArgs);

        $params = array();
        foreach ($keys as $key){
            $params[":$key"] = $assocArray[$key];
        }

        $params[':id'] = $id;
        $sql = "$sql SET $setStatement WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $affectedRows = $stmt->rowCount();
        return $affectedRows;
    }

    public function search($searchName, $first, $second)
    {
        if(empty($searchName)){
            return array();
        }
        $sql = "SELECT * FROM $this->table WHERE $first LIKE :searchName OR $second LIKE :searchName";
        $stmt = $this->db->prepare($sql);
        $params = array(
            ':searchName' => "%" . $searchName . "%",
            ':searchName' => "%" . $searchName . "%"
        );
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result;
    }
}


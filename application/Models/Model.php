<?php

namespace Application\Models;

use Application\Core\Db;

/**
 * Class Model
 * Abstract class that contains basic CRUD logic for communicating with database
 * All other models need to extend abstract Model in order to use them
 * @package Application\Models
 */
abstract class Model
{
    /** @var \PDO object database access layer */
    public $db;
    /** @var string table name */
    public $table;

    /**
     * Model constructor.
     * @param string $table this parameter is set by extended class
     */
    function __construct($table)
    {
        $this->table = $table;
        $this->db = Db::getPdo();
    }

    /**
     * Get records from database where given condition is satisfied
     * @param string $key column name
     * @param mixed $value
     * @param int $limit limits the number of records returned
     * @param string $order default is ASC
     * @return array of objects of called class
     */
    private function doGetWhere($key, $value, $limit, $order)
    {
        //SELECT email FROM users WHERE email = :email (LIMIT 1);
        $sql = "SELECT * FROM $this->table WHERE $key = :$key";
        if($order == 'DESC'){
            $sql = "$sql ORDER BY id DESC";
        }
        if($limit > 0){
            $sql = "$sql LIMIT $limit";
        }

        $stmt = $this->db->prepare($sql);
        $params = array(
            ":$key" => $value
        );
        $stmt->execute($params);
        //returns a new instance of the requested class, mapping the columns of the result set to named properties in the class
        $result = $stmt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
        return $result;
    }

    /**
     * Get all records from database (LIMIT 0) where given condition is satisfied, order ASC
     * @param $key
     * @param $value
     * @return array
     */
    public function getWhere($key, $value)
    {
        return $this->doGetWhere($key, $value, 0, 'ASC');
    }

    /**
     * Get single record from database (LIMIT 1) where given condition is satisfied, order ASC
     * @param $key
     * @param $value
     * @return object
     */
    public function getFirstWhere($key, $value)
    {
        $result = $this->doGetWhere($key, $value, 1, 'ASC');
        $first = null;
        if(!empty($result)){
            $first = $result[0];
        }

        return $first;
    }

    /**
     * Get single record by id from database
     * @param int $id
     * @return object
     */
    public function get($id)
    {
        return $this->getFirstWhere('id', $id);
    }

    /**
     * Get all records from database
     * @return array
     */
    public function getAll()
    {
        return $this->getWhere('1', '1');
    }

    /**
     * Get last two records from database (LIMIT 2) where given condition is satisfied, order DESC
     * @param $key
     * @param $value
     * @return array
     */
    public function getLastTwo($key, $value)
    {
        return $this->doGetWhere($key, $value, 2, 'DESC');
    }

    /**
     * Check for existence of specific record in database
     * @param $key
     * @param $value
     * @return bool returns true if record exists otherwise false
     */
    public function exists($key, $value)
    {
        $result = $this->getFirstWhere($key, $value);
        return $result !== null ? true : false;
    }

    /**
     * Count number of records in database
     * @return int
     */
    public function count()
    {
        $sql = "SELECT COUNT(id) AS count FROM $this->table";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch()->count;
        return $result;
    }

    /**
     * Soft delete record by id in database (changes the deleted column value from 0 to 1)
     * @param $id
     * @return int return number of affected rows (1)
     */
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

    /**
     * Save a record to database
     */
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

    /**
     * Update a record in database
     * @return int return number of affected rows (1)
     */
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

    /**
     * Get all records from database where given first or second condition is satisfied
     * @param $searchName
     * @param $first
     * @param $second
     * @return array
     */
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


<?php

namespace Application\Models;

use PDO;
use PDOException;

class Model
{
    private $db;
    protected $table;
    private $query;
    public $result;
    public $count = 0;
    private $error = false;
    private $shouldFetch = false;

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
    /*
    public function get($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
        return $query->fetchAll();
    }
    */
    public function getAll()
    {
        $sql = "SELECT * FROM " . $this->table;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    /*
    public function count()
    {
        $sql = "SELECT COUNT(id) AS count FROM " . $this->table;
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetch()->count;
    }
    */
    /*
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
        $query = $this->db->prepare($sql);
        $parameters = array(':id' => $id);
        $query->execute($parameters);
    }
    */

        public function query($sql, $params = array())
        {
            $this->error = false;
            if($this->query = $this->db->prepare($sql)) {
                $pos = 1;
                if (count($params)) {
                    foreach ($params as $param)
                        $this->query->bindValue($pos, $param);
                        $pos++;
                }

                if ($this->query->execute()) {
                    if($this->shouldFetch) {
                        $this->result = $this->query->fetchAll(PDO::FETCH_OBJ);
                    }
                    $this->count = $this->query->rowCount();
                } else {
                    $this->error = true;
                }
            }

            return $this;
        }

        public function action($action, $where = array()){
            $sql = "{$action} FROM {$this->table}";
            $params = array();
            if(count($where) !== 3 and count($where)!==0){
                return false;
            }
            if((count($where)) === 3){
                $operators = array('=', '>', '<', '>=', '<=');

                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];

                if(!in_array($operator, $operators)) {
                    return false;
                }

                $params = array($value);
                $sql = "{$sql} WHERE {$field} {$operator} ?";
            }

            if(!$this->query($sql, $params)->error()){
                return $this;
            }
            return false;
        }

        public function get($where = array()){
            $this->shouldFetch = true;
            return $this->action('SELECT * ', $where);
        }

        public function delete($where){
            return $this->action('DELETE ', $where);
        }

        public function error()
        {
            return $this->error;
        }

        public function count()
        {
            return $this->count();
        }
}


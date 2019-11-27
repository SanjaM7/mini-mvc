<?php

namespace Application\Models;

class Role extends Model
{
    public $id;
    public $name;

    public function __construct(){
        parent::__construct('roles');
    }

    public function validateRoleParams()
    {
        $errors = [];
        if (empty($this->name) || strlen($this->name) > 20) {
            $errors[] = 'Invalid Role';
        }

        return $errors;
    }

    public function getRolesWithUsersCount(){
        $sql = 'SELECT roles.id, roles.name, deleted, COUNT(users.id) as countOfUsers
                FROM roles
                LEFT JOIN users
                ON  roles.id = users.role_id
                GROUP BY roles.id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}

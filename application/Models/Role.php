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
        $errors = array();
        if (empty($this->name) || strlen($this->name) > 20) {
            $errors[] = 'Invalid Role';
        }

        return $errors;
    }

    public function getRolesWithUsersCount(){
        $sql = 'SELECT roles.id, roles.name, deleted, COALESCE(countUsers.countOfUsers, 0) as countOfUsers
                FROM roles
                LEFT JOIN (SELECT role_id, COUNT(*) as countOfUsers FROM users GROUP BY role_id) as countUsers
                ON roles.id = countUsers.role_id;'
        ;
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}

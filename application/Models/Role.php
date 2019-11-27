<?php

namespace Application\Models;

/**
 * Class Role
 * This class extends model and represents role record from database
 * @package Application\Models
 */
class Role extends Model
{
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $name;

    /**
     * Role constructor.
     */
    public function __construct(){
        parent::__construct('roles');
    }

    /**
     * Validates role parameter
     * @return string[]
     */
    public function validateRoleParams()
    {
        $errors = [];
        if (empty($this->name) || strlen($this->name) > 20) {
            $errors[] = 'Invalid Role';
        }

        return $errors;
    }

    /**
     * Returns roles with count of users
     * @return object[]
     */
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

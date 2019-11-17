<?php

namespace Application\Models;

class Role extends Model
{
    public $id;
    public $role;

    public function __construct(){
        parent::__construct('roles');
    }

    public function countUsers(){
        $sql = 'SELECT role_id, COUNT(*) as countUsers FROM users GROUP BY role_id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
}

<?php

namespace Application\Models;

class RoleViewModel
{
    public $id;
    public $name;
    public $deleted;
    public $countOfUsers;

    public function __construct($roleWithUsersCount)
    {
        $this->id = $roleWithUsersCount->id;
        $this->name = $roleWithUsersCount->name;
        $this->deleted = $roleWithUsersCount->deleted;
        $this->countOfUsers = $roleWithUsersCount->countOfUsers;
    }
}

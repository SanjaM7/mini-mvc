<?php

namespace Application\Models;

/**
 * Class RoleViewModel
 * This class is only for view role with count of users
 * @package Application\Models
 */
class RoleViewModel
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
     * @var bool
     */
    public $deleted;
    /**
     * @var int
     */
    public $countOfUsers;

    /**
     * RoleViewModel constructor.
     *
     * @param RoleViewModel $roleWithUsersCount
     */
    public function __construct($roleWithUsersCount)
    {
        $this->id = $roleWithUsersCount->id;
        $this->name = $roleWithUsersCount->name;
        $this->deleted = $roleWithUsersCount->deleted;
        $this->countOfUsers = $roleWithUsersCount->countOfUsers;
    }
}

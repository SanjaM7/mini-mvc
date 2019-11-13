<?php

namespace Application\Models;

class User extends Model
{
    public $id;
    public $username;
    public $email;
    public $password;

    public function __construct(){
        parent::__construct('users');

    }
}
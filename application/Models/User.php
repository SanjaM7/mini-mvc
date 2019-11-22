<?php

namespace Application\Models;

class User extends Model
{
    public $id;
    public $username;
    public $email;
    public $hashedPassword;

    public function __construct(){
        parent::__construct('users');
    }

    public function validateRegisterParams($password, $passwordRepeat)
    {
        $errors = array();
        if (!preg_match('/^[A-Za-z][A-Za-z0-9]{2,31}$/', $this->username)) {
            $errors[] = 'Invalid username';
        }
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid e-mail';
        }
        if (strlen($password) < 6 || strlen($password) > 60) {
            $errors[] = 'Invalid password';
        }
        if ($password !== $passwordRepeat) {
            $errors[] = 'Invalid password repeat';
        }
        return $errors;
    }

    public function validateLogInParams($password)
    {
        $errors = array();
        if (empty($this->username)) {
            $errors[] = 'Enter Username';
        }
        if (empty($password)) {
            $errors[] = 'Enter password';
        }
        return $errors;
    }
}

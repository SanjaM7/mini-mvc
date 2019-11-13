<?php

namespace Application\Controllers;

use Application\Models\User;

class UserController
{
    public $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function register()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/register.php';
        require APP . 'view/_templates/footer.php';
    }

    public function logIn()
    {
        require APP . 'view/_templates/header.php';
        require APP . 'view/user/log_in.php';
        require APP . 'view/_templates/footer.php';
    }

    public function postRegister()
    {
        if (isset($_POST["submit_register"])) {
            $this->model->username = $_POST['username'];
            $this->model->email = $_POST['email'];
            $this->model->password = $_POST['password'];
            $this->model->passwordRepeat = $_POST['passwordRepeat'];

            die(var_dump($this->model));
        }
    }
}
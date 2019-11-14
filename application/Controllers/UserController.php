<?php

namespace Application\Controllers;

use Application\Libs\SessionHelper;
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
        $errors = SessionHelper::getAndClearError();
        require ROOT . 'view/_templates/header.php';
        require ROOT . 'view/user/register.php';
        require ROOT . 'view/_templates/footer.php';
    }

    public function logIn()
    {
        $errors = SessionHelper::getAndClearError();
        require ROOT . 'view/_templates/header.php';
        require ROOT . 'view/user/log_in.php';
        require ROOT . 'view/_templates/footer.php';
    }

    public function postRegister()
    {
        if (isset($_POST["submit_register"])) {
            $this->model->username = $_POST['username'];
            $this->model->email = $_POST['email'];
            $password = $_POST['password'];
            $this->model->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $passwordRepeat = $_POST['passwordRepeat'];

            $errors = array();
            $errors = $this->model->validateRegisterParams($password, $passwordRepeat);

            if($errors){
                SessionHelper::setErrors($errors);
                header('location: ' . URL . 'user/register');
                return;
            }

            if($this->model->exists('username', $this->model->username)){
                $errors[] = "Username taken";
            }
            if($this->model->exists('email', $this->model->email)){
                $errors[] = "Email taken";
            }

            if($errors){
                SessionHelper::setErrors($errors);
                header('location: ' . URL . 'user/register');
                return;
            }

            $this->model->save();
            header('location: ' . URL . 'home/index');
        }
    }

    public function postLogIn()
    {
        if(isset($_POST["submit_log_in"])){
            $this->model->username = $_POST["username"];
            $password = $_POST["password"];

            $errors = $this->model->validateLogInParams($password);

            if($errors){
                SessionHelper::setErrors($errors);
                header('location: ' . URL . 'user/logIn');
                return;
            }

            $this->model = $this->model->getWhere('username', $this->model->username);

            if(!isset($this->model->email)){
                $errors[] = "Username does not exists";
            } elseif (!password_verify($password, $this->model->hashedPassword)){
                $errors[] = "Inccorect password";
            }

            if($errors){
                SessionHelper::setErrors($errors);
                header('location: ' . URL . 'user/logIn');
                return;
            }

            SessionHelper::logIn($this->model->id);
            header('location: ' . URL . 'home/index');
        }
    }
}

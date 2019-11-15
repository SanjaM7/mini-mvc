<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
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
        SessionHelper::requireUnauthorized();
        PageHelper::displayPage("user/register.php");
    }

    public function logIn()
    {
        SessionHelper::requireUnauthorized();
        PageHelper::displayPage("user/log_in.php");
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
                PageHelper::displayPage("user/register.php", $params = array('errors' => $errors));
                return;
            }

            if($this->model->exists('username', $this->model->username)){
                $errors[] = "Username taken";
            }
            if($this->model->exists('email', $this->model->email)){
                $errors[] = "Email taken";
            }

            if($errors){
                PageHelper::displayPage("user/register.php", $params = array('errors' => $errors));
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
                PageHelper::displayPage("user/log_in.php", $params = array('errors' => $errors));
                return;
            }

            $this->model = $this->model->getWhere('username', $this->model->username);

            if(!isset($this->model->email)){
                $errors[] = "Username does not exists";
            } elseif (!password_verify($password, $this->model->hashedPassword)){
                $errors[] = "Incorrect password";
            }

            if($errors){
                PageHelper::displayPage("user/log_in.php", $params = array('errors' => $errors));
                return;
            }

            SessionHelper::logIn($this->model->id);

            header('location: ' . URL . 'home/index');
        }
    }

    public function postLogOut()
    {
        SessionHelper::logOut();
        header('location: ' . URL . 'home/index');
    }
}

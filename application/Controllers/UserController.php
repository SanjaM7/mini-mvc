<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Models\Role;
use Application\Models\User;

class UserController
{
    public $model;

    public function __construct()
    {
        $this->model = new User();
    }

    public function index()
    {
        PermissionHelper::requireAdmin();
        $users = $this->model->getAll();
        $count_of_users = $this->model->count();
        $role = new Role();
        $roles = $role->getAll();
        $params = array(
            'users' => $users,
            'count_of_users' => $count_of_users,
            'roles' => $roles
        );

        PageHelper::displayPage('users/index.php', $params);
    }

    public function editUserRole($user_id)
    {
        PermissionHelper::requireAdmin();
        if(isset($user_id)){
            $user = $this->model->get($user_id);
            $role = new Role();
            $roles = $role->getAll();
            $params = array(
                'user' => $user,
                'roles' => $roles
            );
            PageHelper::displayPage('users/edit.php', $params);
        } else {
            PageHelper::redirect('user/index');
        }
    }

    public function updateUserRole()
    {
        PermissionHelper::requireAdmin();
        if (isset($_POST['submit_update_user_role'])) {
            $this->model = $this->model->get($_POST['user_id']);
            $this->model->role_id = $_POST['role_id'];
            $this->model->update();
        }

        PageHelper::redirect('user/index');
    }

    public function register()
    {
        PermissionHelper::requireUnauthorized();
        PageHelper::displayPage('users/register.php');
    }

    public function logIn()
    {
        PermissionHelper::requireUnauthorized();
        PageHelper::displayPage('users/log_in.php');
    }

    public function postRegister()
    {
        PermissionHelper::requireUnauthorized();
        if (isset($_POST['submit_register'])) {
            $this->model->username = $_POST['username'];
            $this->model->email = $_POST['email'];
            $password = $_POST['password'];
            $this->model->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $passwordRepeat = $_POST['passwordRepeat'];

            $errors = $this->model->validateRegisterParams($password, $passwordRepeat);

            if($errors){
                PageHelper::displayPage('users/register.php', $params = array('errors' => $errors));
                return;
            }

            if($this->model->exists('username', $this->model->username)){
                $errors[] = 'Username taken';
            }
            if($this->model->exists('email', $this->model->email)){
                $errors[] = 'Email taken';
            }

            if($errors){
                PageHelper::displayPage('users/register.php', $params = array('errors' => $errors));
                return;
            }

            $this->model->save();
            PageHelper::redirect('users/log_in');
        }
    }

    public function postLogIn()
    {
        PermissionHelper::requireUnauthorized();
        if(isset($_POST['submit_log_in'])){
            $this->model->username = $_POST['username'];
            $password = $_POST['password'];

            $errors = $this->model->validateLogInParams($password);

            if($errors){
                PageHelper::displayPage('users/log_in.php', $params = array('errors' => $errors));
                return;
            }

            $this->model = $this->model->getFirstWhere('username', $this->model->username);

            if(!isset($this->model->email)){
                $errors[] = 'Username does not exists';
            } elseif (!password_verify($password, $this->model->hashedPassword)){
                $errors[] = 'Incorrect password';
            } elseif ($this->model->role_id == 3 ){
                $errors[] = 'You are blocked';
            }

            if($errors){
                PageHelper::displayPage('users/log_in.php', $params = array('errors' => $errors));
                return;
            }

            SessionHelper::logIn($this->model->id, $this->model->role_id);

            PageHelper::redirect('home/index');
        }
    }

    public function postLogOut()
    {
        PermissionHelper::requireAuthorized();
        SessionHelper::logOut();
        PageHelper::redirect('home/index');
    }
}

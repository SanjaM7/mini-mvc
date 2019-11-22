<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Libs\ValidationTrait;
use Application\Models\Role;
use Application\Models\User;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    use ValidationTrait;
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
        if (!isset($user_id)) {
            return PageHelper::redirect('user/index');
        }

        $user = $this->model->get($user_id);
        $role = new Role();
        $roles = $role->getAll();
        $params = array(
            'user' => $user,
            'roles' => $roles
        );

        PageHelper::displayPage('users/edit.php', $params);
    }

    public function updateUserRole()
    {
        PermissionHelper::requireAdmin();
        if (isset($_POST['submit_update_user_role'])) {
            $this->model = $this->model->get($_POST['user_id']);
            $this->model->role_id = $_POST['role_id'];
            $this->model->update();
        }

        return PageHelper::redirect('user/index');
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
        if (!isset($_POST['submit_register'])) {
            return PageHelper::redirect('user/register');
        }

        $this->model->username = $_POST['username'];
        $this->model->email = $_POST['email'];
        $password = $_POST['password'];
        $this->model->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $passwordRepeat = $_POST['passwordRepeat'];

        $errors = $this->validateRegister($password, $passwordRepeat, $this->model);

        if ($errors) {
            PageHelper::displayPage('users/register.php', $params = array('errors' => $errors));
            return;
        }

        $this->model->save();
        return PageHelper::redirect('user/logIn');
    }

    public function postLogIn()
    {
        PermissionHelper::requireUnauthorized();
        if (!isset($_POST['submit_log_in'])) {
            return PageHelper::redirect('user/logIn');
        }

        $this->model->username = $_POST['username'];
        $password = $_POST['password'];

        $errors = $this->validateLogIn($password, $this->model);

        if ($errors) {
            PageHelper::displayPage('users/log_in.php', $params = array('errors' => $errors));
            return;
        }

        $this->model = $this->model->getFirstWhere('username', $this->model->username);

        SessionHelper::logIn($this->model->id, $this->model->role_id);

        return PageHelper::redirect('/');
    }

    public function postLogOut()
    {
        PermissionHelper::requireAuthorized();
        if (!isset($_POST['submit_log_out'])) {
            return PageHelper::redirectBack();
        }

        SessionHelper::logOut();
        return PageHelper::redirect('/');
    }
}

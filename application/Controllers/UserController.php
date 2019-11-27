<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Libs\PermissionHelper;
use Application\Validations\UserValidationTrait;
use Application\Models\Role;
use Application\Models\User;
use Illuminate\Routing\Controller;

/**
 * Class UserController
 * This Controller handles working with users: processing input data, executing logic and loading corresponding views
 * @package Application\Controllers
 */
class UserController extends Controller
{
    use UserValidationTrait;

    /**
     * @var object User
     */
    public $model;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     *This method loads view with user and their roles
     * @return void
     */
    public function index()
    {
        PermissionHelper::requireAdmin();
        $users          = $this->model->getAll();
        $count_of_users = $this->model->count();
        $role           = new Role();
        $roles          = $role->getAll();
        $params         = [
            'errors' => [],
            'users' => $users,
            'count_of_users' => $count_of_users,
            'roles' => $roles
        ];

        PageHelper::displayPage('users/index.php', $params);
    }

    /**
     * This method handles editing user role
     * @param int $user_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function editUserRole($user_id)
    {
        PermissionHelper::requireAdmin();
        if (!isset($user_id)) {
            return PageHelper::redirect('user/index');
        }

        $user   = $this->model->get($user_id);
        $role   = new Role();
        $roles  = $role->getAll();
        $params = [
            'errors' => [],
            'user' => $user,
            'roles' => $roles
        ];

        PageHelper::displayPage('users/edit.php', $params);
    }

    /**
     * This method handles updating user role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUserRole()
    {
        PermissionHelper::requireAdmin();
        if (isset($_POST['submit_update_user_role'])) {
            $this->model          = $this->model->get($_POST['user_id']);
            $this->model->role_id = $_POST['role_id'];
            $this->model->update();
        }

        return PageHelper::redirect('user/index');
    }

    /**
     * This method loads register view
     * @return void
     */
    public function register()
    {
        PermissionHelper::requireUnauthorized();
        PageHelper::displayPage('users/register.php', $params = ['errors' => []]);
    }

    /**
     * This method loads log_in view
     * @return void
     */
    public function logIn()
    {
        PermissionHelper::requireUnauthorized();
        PageHelper::displayPage('users/log_in.php', $params = ['errors' => []]);
    }

    /**
     * This method handles the registration of new users as well as their validation and creation.
     * @return void
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function postRegister()
    {
        PermissionHelper::requireUnauthorized();
        if (!isset($_POST['submit_register'])) {
            return PageHelper::redirect('user/register');
        }

        $this->model->username       = $_POST['username'];
        $this->model->email          = $_POST['email'];
        $this->model->hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $errors = $this->validateRegister($_POST['password'], $_POST['passwordRepeat'], $this->model);

        if ($errors) {
            PageHelper::displayPage('users/register.php', $params = ['errors' => $errors]);
            return;
        }

        $this->model->save();
        return PageHelper::redirect('user/logIn');
    }

    /**
     *  This controller handles login users in and redirecting them to home screen
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function postLogIn()
    {
        PermissionHelper::requireUnauthorized();
        if (!isset($_POST['submit_log_in'])) {
            return PageHelper::redirect('user/logIn');
        }

        $this->model->username = $_POST['username'];
        $errors                = $this->model->validateLogInParams($_POST['password']);

        if ($errors) {
            PageHelper::displayPage('users/log_in.php', $params = ['errors' => $errors]);
            return;
        }

        $this->model = $this->model->getFirstWhere('username', $_POST['username']);

        $errors = $this->validateLogIn($_POST['password'], $this->model);

        if ($errors) {
            PageHelper::displayPage('users/log_in.php', $params = ['errors' => $errors]);
            return;
        }

        SessionHelper::logIn($this->model->id, $this->model->role_id);

        return PageHelper::redirect('/');
    }

    /**
     * This controller handles login users out and redirecting them to home screen
     * @return \Illuminate\Http\RedirectResponse
     */
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

<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\PermissionHelper;
use Application\Libs\SessionHelper;
use Application\Models\Role;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public $model;

    public function __construct()
    {
        $this->model = new Role();
        PermissionHelper::requireAdmin();
    }

    public function index()
    {
        $roles = $this->model->getAll();
        $roleIdCountUsers = $this->model->countUsers();
        $params = array(
            'errors' => array(),
            'roles' => $roles,
            'roleIdCountUsers' => $roleIdCountUsers
        );

        PageHelper::displayPage('roles/index.php', $params);
    }

    public function addRole()
    {
        if (isset($_POST['submit_add_role'])) {
            $this->model->name = $_POST['role'];

            $errors = $this->model->validateRoleParams();

            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('role/index');
            }

            $this->model->save();
        }

        return PageHelper::redirect('role/index');
    }

    public function softDeleteRole($role_id)
    {
        if (isset($role_id)) {
            $this->model->softDelete($role_id);
        }

        return PageHelper::redirect('role/index');
    }

    public function editRole($role_id)
    {
        if (isset($role_id)) {
            $role = $this->model->get($role_id);
            $params = array(
                'errors' => array(),
                'role' => $role
            );
            PageHelper::displayPage('roles/edit.php', $params);
            return;
        }

        return PageHelper::redirect('role/index');
    }

    public function updateRole()
    {
        if (isset($_POST['submit_update_role'])) {
            $this->model->id = $_POST['role_id'];
            $this->model->name = $_POST['role'];

            $errors = $this->model->validateRoleParams();

            if ($errors) {
                SessionHelper::setErrors($errors);
                return PageHelper::redirect('role/' . $this->model->id . '/editRole');
            }

            $this->model->update();
        }

        return PageHelper::redirect('role/index');
    }
}

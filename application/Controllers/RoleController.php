<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\PermissionHelper;
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
            'roles' => $roles,
            'roleIdCountUsers' => $roleIdCountUsers
        );

        PageHelper::displayPage('roles/index.php', $params);
    }

    public function addRole()
    {
        if (isset($_POST['submit_add_role'])) {
            $this->model->role = $_POST['role'];
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
            PageHelper::displayPage('roles/edit.php', $params = array('role' => $role));
            return;
        }

        return PageHelper::redirect('role/index');
    }

    public function updateRole()
    {
        if (isset($_POST['submit_update_role'])) {
            $this->model->id = $_POST['role_id'];
            $this->model->role = $_POST['role'];
            $this->model->update();
        }

        return PageHelper::redirect('role/index');
    }
}

<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\PermissionHelper;
use Application\Libs\SessionHelper;
use Application\Models\Role;
use Application\Models\RoleViewModel;
use Illuminate\Routing\Controller;

/**
 * Class RoleController
 * This Controller handles working with roles: processing input data, executing logic and loading corresponding views
 * @package Application\Controllers
 */
class RoleController extends Controller
{
    /**
     * @var object Role
     */
    public $model;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {
        $this->model = new Role();
        PermissionHelper::requireAdmin();
    }

    /**
     * This method loads view with roles and count of users
     * @return void
     */
    public function index()
    {
        $rolesWithUsersCount = $this->model->getRolesWithUsersCount();
        $roleViewModels = $this->mapToRoleViewModel($rolesWithUsersCount);
        $params = [
            'errors' => [],
            'roles' => $roleViewModels
        ];

        PageHelper::displayPage('roles/index.php', $params);
    }

    /**
     *
     * This method handles adding role
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * This method handles soft deleting role
     * @param int $role_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function softDeleteRole($role_id)
    {
        if (isset($role_id)) {
            $this->model->softDelete($role_id);
        }

        return PageHelper::redirect('role/index');
    }

    /**
     * This method handles editing role
     * @param int $role_id
     *
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function editRole($role_id)
    {
        if (isset($role_id)) {
            $role = $this->model->get($role_id);
            $params = [
                'errors' => [],
                'role' => $role
            ];
            PageHelper::displayPage('roles/edit.php', $params);
            return;
        }

        return PageHelper::redirect('role/index');
    }

    /**
     * This method handles updating role
     * @return \Illuminate\Http\RedirectResponse
     */
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

    /**
     * This method maps RoleViewModel
     * @param array $rolesWithUsersCount
     *
     * @return roleViewModel[]
     */
    private function mapToRoleViewModel($rolesWithUsersCount)
    {
        $roleViewModels = [];
        for($i = 0; $i < count($rolesWithUsersCount); $i++){
            $roleViewModel = new RoleViewModel($rolesWithUsersCount[$i]);
            $roleViewModels[] = $roleViewModel;
        }

        return $roleViewModels;
    }
}

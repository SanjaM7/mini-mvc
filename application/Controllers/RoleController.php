<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\SessionHelper;
use Application\Models\Role;

class RoleController
{
    public $model;

    public function __construct()
    {
        $this->model = new Role();
    }

    public function index()
    {
        PageHelper::displayPage("role/index.php");
    }
}

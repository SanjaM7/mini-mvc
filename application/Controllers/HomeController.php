<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\PermissionHelper;


class HomeController
{
    public function index()
    {
        PageHelper::displayPage('home/index.php');
    }

    public function exampleOne()
    {
        PermissionHelper::requireAuthorized();
        PageHelper::displayPage('home/example_one.php');
    }

    public function exampleTwo()
    {
        PermissionHelper::requireAuthorized();
        PageHelper::displayPage('home/example_two.php');
    }
}

<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\PermissionHelper;
use Illuminate\Routing\Controller;

/**
 * Class HomeController
 * @package Application\Controllers
 */
class HomeController extends Controller
{
    public function index()
    {
        PageHelper::displayPage('home/index.php', $params = array('errors' => array()));
    }

    public function exampleOne()
    {
        PermissionHelper::requireAuthorized();
        PageHelper::displayPage('home/example_one.php', $params = array('errors' => array()));
    }

    public function exampleTwo()
    {
        PermissionHelper::requireAuthorized();
        PageHelper::displayPage('home/example_two.php', $params = array('errors' => array()));
    }
}

<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Application\Libs\PermissionHelper;
use Illuminate\Routing\Controller;

/**
 * Class HomeController
 * This Controller loads home and basic views
 * @package Application\Controllers
 */
class HomeController extends Controller
{
    /**
     * This method loads home view page
     * @return void
     */
    public function index()
    {
        PageHelper::displayPage('home/index.php', $params = ['errors' =>[]]);
    }

    /**
     * This method loads exemple_one page
     * @return void
     */
    public function exampleOne()
    {
        PermissionHelper::requireAuthorized();
        PageHelper::displayPage('home/example_one.php', $params = ['errors' => []]);
    }

    /**
     * This method loads exemple_two page
     * @return void
     */
    public function exampleTwo()
    {
        PermissionHelper::requireAuthorized();
        PageHelper::displayPage('home/example_two.php', $params = ['errors' => []]);
    }
}

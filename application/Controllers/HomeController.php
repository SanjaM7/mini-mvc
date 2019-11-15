<?php

namespace Application\Controllers;

use Application\Libs\SessionHelper;
use Application\Libs\PageHelper;

class HomeController
{
    public function index()
    {
        PageHelper::displayPage("home/index.php");
    }

    public function exampleOne()
    {
        PageHelper::displayPage("home/example_one.php");
    }

    public function exampleTwo()
    {
        PageHelper::displayPage("home/example_two.php");
    }
}

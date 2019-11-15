<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;

class ProblemController
{
    public function index()
    {
        PageHelper::displayPage("problem/index.php");
    }
}

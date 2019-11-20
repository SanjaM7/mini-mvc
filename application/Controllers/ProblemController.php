<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Illuminate\Routing\Controller;

class ProblemController extends Controller
{
    public function index()
    {
        PageHelper::displayPage('problem/index.php');
    }
}

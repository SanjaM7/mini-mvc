<?php

namespace Application\Controllers;

use Application\Libs\PageHelper;
use Illuminate\Routing\Controller;

/**
 * Class ProblemController
 * This controller handles the errors and loads corresponding view
 * @package Application\Controllers
 */
class ProblemController extends Controller
{
    /**
     * This method handles the error page that will be shown when a page is not found
     * @return void
     */
    public function index()
    {
        PageHelper::displayPage('problem/index.php', $params = ['errors' => []]);
    }
}

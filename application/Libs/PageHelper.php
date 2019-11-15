<?php

namespace Application\Libs;

class PageHelper
{
    public static function displayPage($viewName, $params = array())
    {
        $isLoggedIn = SessionHelper::isUserLoggedIn();
        $isAdmin = SessionHelper::isAdmin();
        // load views
        require ROOT . 'view/_templates/header.php';
        require ROOT . 'view/' . $viewName;
        require ROOT . 'view/_templates/footer.php';
    }
}

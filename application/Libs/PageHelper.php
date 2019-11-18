<?php

namespace Application\Libs;

class PageHelper
{
    public static function displayPage($viewName, $params = array())
    {
        $isLoggedIn = SessionHelper::isUserLoggedIn();
        if($isLoggedIn) {
            $isDj = SessionHelper::isDj();
            $isAdmin = SessionHelper::isAdmin();
        }
        // load views
        require ROOT . 'view/_templates/header.php';
        require ROOT . 'view/' . $viewName;
        require ROOT . 'view/_templates/footer.php';
    }

    public static function redirect($url)
    {
        header('location: ' . URL . $url);
    }

    public static function redirectBack()
    {
        header('location: ' . $_SERVER['HTTP_REFERER']);
    }

}

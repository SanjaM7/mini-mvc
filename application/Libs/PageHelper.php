<?php

namespace Application\Libs;

class PageHelper
{
    public static function displayPage($viewName, $params = array())
    {
        $isLoggedIn = SessionHelper::isUserLoggedIn();
        if(empty($params['errors'])){
            $errors = array (
                'errors' => SessionHelper::getAndClearErrors()
            );
            $params = array_merge($params, $errors);
        }
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
        global $redirect;
        return $redirect->to($url);
    }

    public static function redirectBack()
    {
        global $redirect;
        return $redirect->to($_SERVER['HTTP_REFERER']);
    }

}

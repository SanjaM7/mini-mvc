<?php

namespace Application\Libs;

use Illuminate\Http\RedirectResponse;

/**
 * Class PageHelper
 * This helper class is responsible for loading passed view with parameters and redirecting
 * @package Application\Libs
 */
class PageHelper
{
    /**
     * Loads passed page with params, get errors and passes authentication params to view
     * @param string $viewName
     * @param array $params
     * @return void
     */
    public static function displayPage($viewName, $params = [])
    {
        $isLoggedIn = SessionHelper::isUserLoggedIn();
        if(empty($params['errors'])){
            $errors = [
                'errors' => SessionHelper::getAndClearErrors()
            ];
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

    /**
     * Redirect to passed route
     * @param string $url
     * @return RedirectResponse
     */
    public static function redirect($url)
    {
        global $redirect;
        return $redirect->to($url);
    }

    /**
     * Redirect user to their previous location
     * @return RedirectResponse
     */
    public static function redirectBack()
    {
        global $redirect;
        return $redirect->to($_SERVER['HTTP_REFERER']);
    }

}

<?php

namespace Application\Libs;

use Application\Libs\SessionHelper;

class PermissionHelper
{
    public static function requireAuthorized()
    {
        if(!SessionHelper::isUserLoggedIn()){
            header('location: ' . URL . 'user/logIn');
        }
    }

    public static function requireUnauthorized()
    {
        if(SessionHelper::isUserLoggedIn()){
            header('location: ' . URL . 'home/index');
        }
    }

    public static function requireAdmin()
    {
        if(!SessionHelper::isAdmin()){
            header('location: ' . URL . 'home/index');
        }
    }

    public static function requireDj()
    {
        if(!SessionHelper::isDj()){
            header('location: ' . URL . 'home/index');
        }
    }
}

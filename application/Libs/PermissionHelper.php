<?php

namespace Application\Libs;

use Application\Libs\SessionHelper;
use Application\Libs\PageHelper;

/**
 * Class PermissionHelper
 * This helper class is responsible for granting or denying access for certain resource
 * @package Application\Libs
 */
class PermissionHelper
{
    /**
     * The user needs to be logged in to see certain resource
     * @return void
     */
    public static function requireAuthorized()
    {
        if(!SessionHelper::isUserLoggedIn()){
            header('location: ' . (string)getenv('URL') . 'user/logIn');
        }
    }

    /**
     * The user needs to be logged out to see certain resource
     * @return void
     */
    public static function requireUnauthorized()
    {
        if(SessionHelper::isUserLoggedIn()){
            header('location: ' . (string)getenv('URL') . '/');
        }
    }

    /**
     * The user needs to be admin to see certain resource
     * @return void
     */
    public static function requireAdmin()
    {
        if(!SessionHelper::isAdmin()){
            header('location: ' . (string)getenv('URL') . '/');
        }
    }

    /**
     * The user needs to be dj to see certain resource
     * @return void
     */
    public static function requireDj()
    {
        if(!SessionHelper::isDj()){
            header('location: ' . (string)getenv('URL') . '/');
        }
    }
}

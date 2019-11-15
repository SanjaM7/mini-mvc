<?php

namespace Application\Libs;

class SessionHelper
{
    public static function logIn($id, $role_id)
    {
        $_SESSION['id'] = $id;
        $_SESSION['role_id'] = $role_id;
    }

    public static function logOut()
    {
        $_SESSION['id'] = null;
        $_SESSION['role_id'] = null;
    }

    public static function isUserLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    public static function getUserId()
    {
        return $_SESSION['id'];
    }

    public static function requireAuthorized()
    {
        if(!self::isUserLoggedIn()){
            header('location: ' . URL . 'user/logIn');
        }
    }

    public static function requireUnauthorized()
    {
        if(self::isUserLoggedIn()){
            header('location: ' . URL . 'home/index');
        }
    }

    public static function isAdmin()
    {
        return ($_SESSION['role_id'] == 2 ? true : false);
    }
}

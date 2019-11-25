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

    public static function isDj()
    {
        return ($_SESSION['role_id'] == 1 ? true : false);
    }

    public static function isAdmin()
    {
        return ($_SESSION['role_id'] == 2 ? true : false);
    }

    public static function setErrors($errors)
    {
        $_SESSION['errors'] = $errors;
    }

    public static function getAndClearErrors()
    {
        $errors = array();
        if(isset($_SESSION['errors'])){
            $errors = $_SESSION['errors'];
            $_SESSION['errors'] = null;
        }

        return $errors;
    }

}

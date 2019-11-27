<?php

namespace Application\Libs;

/**
 * Class SessionHelper
 * This helper class is responsible for retrieving and storing data in the session and authentication of user
 * @package Application\Libs
 */
class SessionHelper
{
    /**
     * Stores logged user id and role id in session
     * @param int $id
     * @param int $role_id
     * @return void
     */
    public static function logIn($id, $role_id)
    {
        $_SESSION['id'] = $id;
        $_SESSION['role_id'] = $role_id;
    }

    /**
     * Removes user data from session
     * @return void
     */
    public static function logOut()
    {
        $_SESSION['id'] = null;
        $_SESSION['role_id'] = null;
    }

    /**
     * Determine if user is logged in
     * @return bool
     */
    public static function isUserLoggedIn()
    {
        return isset($_SESSION['id']);
    }

    /**
     * Retrieve user id from session
     * @return int
     */
    public static function getUserId()
    {
        return $_SESSION['id'];
    }

    /**
     * Determine if user is dj
     * @return bool
     */
    public static function isDj()
    {
        return ($_SESSION['role_id'] == 1 ? true : false);
    }

    /**
     * Determine if user is admin
     * @return bool
     */
    public static function isAdmin()
    {
        return ($_SESSION['role_id'] == 2 ? true : false);
    }

    /**
     * Stores errors in session
     * @param $errors
     * @return void
     */
    public static function setErrors($errors)
    {
        $_SESSION['errors'] = $errors;
    }

    /**
     * Serves for displaying flash massages
     * @return string[]
     */
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

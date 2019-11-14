<?php

namespace Application\Libs;

class SessionHelper
{
    public static function setErrors(array $errors)
    {
        $_SESSION['errors'] = $errors;
    }

    public static function getAndClearError()
    {
        $errors = array();
        if(isset($_SESSION['errors'])){
            $errors = $_SESSION['errors'];
            $_SESSION['errors'] = null;
        }

        return $errors;
    }

    public static function logIn($id)
    {
        $_SESSION['id'] = $id;
    }

    public static function getUserId()
    {
        return $_SESSION['id'];
    }
}

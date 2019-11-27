<?php

namespace Application\Validations;

/**
 * Trait UserValidationTrait
 * This trait groups the validate functionality and removes it from user controller
 * @package Application\Validations
 */
trait UserValidationTrait
{
    /**
     * Validates user credentials for registering
     * @param string $password
     * @param string $passwordRepeat
     * @param object $user
     * @return string[]
     */
    public function validateRegister($password, $passwordRepeat, $user)
    {
        $errors = $user->validateRegisterParams($password, $passwordRepeat);

        if ($errors) {
            return $errors;
        }

        if ($user->exists('username', $this->model->username)) {
            $errors[] = 'Username taken';
            return $errors;
        }

        if ($user->exists('email', $this->model->email)) {
            $errors[] = 'Email taken';
        }

        return $errors;
    }

    /**
     * Validates user credentials for login
     * @param string $password
     * @param object $user
     * @return string[]
     */
    public function validateLogIn($password, $user)
    {
        $errors = [];
        if (!isset($user->email)) {
            $errors[] = 'Username does not exists';
            return $errors;
        }

        if (!password_verify($password, $user->hashedPassword)) {
            $errors[] = 'Incorrect password';
            return $errors;
        }

        if ($user->role_id == 3) {
            $errors[] = 'You are blocked';
        }

        return $errors;
    }
}

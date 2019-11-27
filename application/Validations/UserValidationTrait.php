<?php

namespace Application\Validations;

trait UserValidationTrait
{
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

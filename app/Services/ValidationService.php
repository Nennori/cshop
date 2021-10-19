<?php


namespace App\Services;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ValidationService
{

    static function validateEmail(string $email)
    {
        $pattern = "/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix";
        if(!preg_match($pattern, $email)) {
            throw ValidationException::withMessages([
                'email' => ['The email must be a valid email address.'],
            ]);
        }
    }

    static function validateEmailUnique(string $email, Model $model)
    {
        if ($model::query()->where('email', $email)->exists()){
            throw ValidationException::withMessages([
                'email' => ['User with this email already registered'],
            ]);
        }
    }

    public static function validateAuthorizedUser($data)
    {
        if (!auth()->once($data)) {
            throw ValidationException::withMessages([
                'password' => ['Invalid password'],
            ]);
        }
    }


}

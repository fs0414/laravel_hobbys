<?php

namespace App\Services\Auth;

class UserRegisterService
{
    public function userRegisterToken($register_user)
    {
        $token = $register_user->createToken('auth_token')->plainTextToken;

        return $token;
    }
}
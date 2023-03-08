<?php

namespace App\Services\Auth;
use Laravel\Sanctum\HasApiTokens;

class UserRegisterService
{
    use HasApiTokens;

    public function userRegisterToken($user)
    {
        $token = $user->createToken('auth_token')->plainTextToken;

        return $token;
    }
}
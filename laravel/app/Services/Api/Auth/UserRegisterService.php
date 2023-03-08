<?php

namespace App\Services\Api\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
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
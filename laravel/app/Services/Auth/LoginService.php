<?php

namespace App\Services\Auth;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LoginService
{
     use HasApiTokens, HasFactory, Notifiable;
    public function loginAttempt($credentials)
    {
        if(! Auth::attempt($credentials))  {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        };
    }

    public function tokenPublishing($login_user)
    {
        try {
            $token = $login_user->createToken('auth_token')->plainTextToken;

            return $token;
        }catch (\Exception $e) {
            $e->getMessage();
        };
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login()
    {
        try {
            $credentials = request(['email', 'password']);

            if (! $token = Auth::attempt($credentials)) {
                throw new \Exception('unAuthentication');
            }

            $arrayData = [ $token, 'authUser' => Auth::user() ];

            return $arrayData;
        } catch ( \Exception $e) {
            echo $e->getMessage();
        }
    }

    public function logout()
    {
        dd('logout true');
    }
}

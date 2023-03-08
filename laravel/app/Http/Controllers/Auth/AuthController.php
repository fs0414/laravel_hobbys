<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\UserRegisterService;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['register', 'login']]);
    }
    public function register(UserRegisterRequest $request, User $user, UserRegisterService $userRegisterService)
    {
        try {
            $register_user = $user->userRegister($request);

            $token = $userRegisterService->userRegisterToken($register_user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer'
            ]);

        } catch ( \Exception $e) {
            echo $e->getMessage();
        };
    }

    public function login(LoginRequest $loginRequest, LoginService $loginService, User $user)
    {
        try {
            $credentials = $loginRequest->all();

            $loginService->loginAttempt($credentials);

            $login_user = $user->loginVerify($loginRequest);

            $login_user = auth()->user();

            $token = $loginService->tokenPublishing($login_user);

            return response()->json(['access_token' => $token, 'token_type' => 'bearer']);
        } catch (\Exception $e) {
            $e->getMessage();
        };
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        Auth::guard('sanctum')->user()->tokens()->delete();

        return response()->json([ 'message' => 'logout success' ]);
    }
}


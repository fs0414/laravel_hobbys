<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\LoginService;
use App\Services\Auth\UserRegisterService;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['allUser', 'register', 'login']]);
    }

    public function allUser(): JsonResponse
    {
        $users = User::with('articles')->get();

        return response()->json([
            'status_code' => 200,
            'users' => UserResource::collection($users)
        ]);
    }

    public function register(UserRegisterRequest $request, User $user, UserRegisterService $userRegisterService)
    {
        try {
            $new_user = $user->userRegister($request);

            return response()->json([
                'status_code' => 201,
                'new_user' => $new_user
            ]);

        } catch ( \Exception $e) {
            $e->getMessage();
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

            return response()->json([
                'status_code' => 201, 'access_token' => $token
            ]);
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

        return response()->json([
            'message' => 'logout success'
        ]);
    }

    public function redirectRoot()
    {
        return view('welcome');
    }
}


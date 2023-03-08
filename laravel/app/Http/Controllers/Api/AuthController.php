<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\Auth\UserRegisterService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function register(UserRegisterRequest $request, User $userModel, UserRegisterService $userRegisterService)
    {
        try {
            $user = $userModel->userRegister($request);

            $token = $userRegisterService->userRegisterToken($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer'
            ]);

        } catch ( \Exception $e) {
            echo $e->getMessage();
        };
    }
}

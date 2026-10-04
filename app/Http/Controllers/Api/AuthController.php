<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        // لو الداتا غلط الـ Service بترمي Exception والـ handler بيرجعها JSON
        $user  = $this->authService->authenticate($data['email'], $data['password']);
        $token = $user->createToken('api')->plainTextToken;

        return $this->success(['user' => $user, 'token' => $token], 'Logged in successfully');
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Logged out successfully');
    }
}

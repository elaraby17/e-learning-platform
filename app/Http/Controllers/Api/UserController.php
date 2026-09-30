<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ApiResponseTrait;

class UserController extends Controller
{
    use ApiResponseTrait;

    public $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users = $this->userService->getAllUsers();
            return $this->success($users, 'Users retrieved successfully', 200);
        } catch (\Throwable $th) {
            return $this->error('Failed to retrieve users', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->userService->createUser($request);
            return $this->success($user, 'User created successfully', 201);
        } catch (\Throwable $th) {
            return $this->error('Failed to create user', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->userService->updateUser($request, $user);
            return $this->success($user, 'User updated successfully', 200);
        } catch (\Throwable $th) {
            return $this->error('Failed to update user', 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->success(null, 'User deleted successfully', 200);
        } catch (\Throwable $th) {
            return $this->error('Failed to delete user', 500);
        }
    }
}

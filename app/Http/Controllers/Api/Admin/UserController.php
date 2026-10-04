<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\Admin\AdminUserService;
use App\Traits\ApiResponseTrait;

// نفس الـ Service بتاعة الويب - بس بترجع JSON
class UserController extends Controller
{
    use ApiResponseTrait;

    public function __construct(private AdminUserService $userService) {}

    public function index()
    {
        return $this->success($this->userService->paginate(), 'Users retrieved successfully');
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userService->create($request->validated());

        return $this->success($user, 'User created successfully', 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user = $this->userService->update($user, $request->validated());

        return $this->success($user, 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $this->userService->delete($user, auth()->user());

        return $this->success(null, 'User deleted successfully');
    }
}

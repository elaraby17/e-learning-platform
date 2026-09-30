<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
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
        $users = $this->userService->getAllUsers();

        return view('admins.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admins.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $this->userService->createUser($request);

            return redirect()->route('admin.users.index')
                ->with('success', 'تم إنشاء حساب المستخدم بنجاح.');
        } catch (\Throwable $th) {
            Log::info('Error creating user: '.$th->getMessage());

            return back()->with('error', 'حدث خطأ اثناء انشاء حساب المستخدم.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admins.users.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admins.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $this->userService->updateUser($request, $user);
            return redirect()->route('admin.users.index')
                ->with('success', 'تم تحديث بيانات المستخدم بنجاح.');

        } catch (\Throwable $th) {
            Log::info('Error Updating user: '.$th->getMessage());

            return back()->with('error', 'حدث خطأ اثناء تحديث بيانات المستخدم.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return back()->with('status', 'user-deleted');
        } catch (\Throwable $th) {
            Log::info('Error Deleting user: '.$th->getMessage());
            return back()->with('error', 'حدث خطأ اثناء حذف المستخدم.');
        }
    }
}

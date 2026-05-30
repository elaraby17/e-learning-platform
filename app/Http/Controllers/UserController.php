<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'user')->orderBy('created_at', 'desc')->paginate(10);

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
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20|unique:users,phone|starts_with:010,011,012,015',
                'role' => 'required|in:user,instructor,admin',
                'status' => 'required|in:active,inactive',
                'gender' => 'nullable|in:male,female,other',
                'bio' => 'nullable|string|max:1000',
                'password' => 'required|string|min:8|confirmed',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('users', 'public');
                $validatedData['image'] = $path;
            }

            $validatedData['password'] = Hash::make($request->password);

            User::create($validatedData);

            return redirect()->route('users.index')
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
    public function update(Request $request, User $user)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
                'phone' => 'required|string|max:20|unique:users,phone,'.$user->id,
                'status' => 'required|in:active,inactive',
                'gender' => 'nullable|in:male,female,other',
                'bio' => 'nullable|string|max:1000',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
                'password' => 'nullable|string|min:8',
            ]);

            if ($request->hasFile('image')) {
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }

                $path = $request->file('image')->store('users', 'public');
                $validatedData['image'] = $path;
            }

            if ($request->filled('password')) {
                $validatedData['password'] = Hash::make($request->password);
            } else {
                unset($validatedData['password']);
            }

            $user->update($validatedData);

            return redirect()->route('users.index')
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

@extends('layouts.master')

@section('title', 'login')

@section('content')
    <div class="container h-screen f">
        <div class=" mx-auto p-8 rounded-lg flex gap-6">
            <div class="w-1/2 h-[75vh]  flex flex-col justify-center">
                <h2 class="text-2xl font-bold mb-6 text-center">تسجيل دخول</h2>
            <x-erorr-component />
                <form method="POST" action="{{ route('auth.signin') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('email')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 mb-2">كلمة المرور</label>
                        <input id="password" type="password" name="password"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('password')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4 flex items-center">
                        <label for="remember" class="block text-gray-700 mb-2">تذكرني</label>
                        <input id="remember" type="checkbox" name="remember"
                            class="mr-2 leading-tight ">
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition duration-300">إنشاء
                        الحساب</button>
                </form>
            </div>
            <div class="w-1/2 hidden md:block bg-indigo-100 rounded-lg overflow-hidden">
                <img src="{{ asset('assets/images/auth/laptop-with-login-password-form-screen.jpg') }}" alt="Register Image"
                    class="w-full h-full object-cover rounded-lg">
            </div>
        </div>
    </div>
@endsection

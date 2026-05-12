@extends('layouts.master')

@section('title', 'register')

@section('content')
    <div class="container h-screen f">
        <div class=" mx-auto p-8 rounded-lg flex gap-6">
            <div class="w-1/2 hidden md:block">
                <h2 class="text-2xl font-bold mb-6 text-center">إنشاء حساب جديد</h2>
                <form method="POST" action="{{ route('auth.signup') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 mb-2">الاسم الكامل</label>
                        <input id="name" type="text" name="name" required autofocus
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('name')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 mb-2">البريد الإلكتروني</label>
                        <input id="email" type="email" name="email" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('email')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-700 mb-2">رقم الهاتف</label>
                        <input id="phone" type="text" name="phone" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="bio" class="block text-gray-700 mb-2">سيرة ذاتية</label>
                        <textarea name="bio" id="bio" cols="45" rows="2"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300"></textarea>
                        @error('bio')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 mb-2">صورة الحساب</label>
                        <input id="image" type="file" name="image"
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('image')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password" class="block text-gray-700 mb-2">كلمة المرور</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('password')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-gray-700 mb-2">تأكيد كلمة المرور</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-300">
                        @error('password')
                            <p class="text-xs text-red-500 mt-0.5">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition duration-300">إنشاء
                        الحساب</button>
                </form>
            </div>
            <div class="w-1/2 hidden md:block bg-indigo-100 rounded-lg overflow-hidden">
                <img src="{{ asset('assets/images/auth/hand-holding-writing-checklist-application-form-document-clipboard-white-background-3d-illustration.jpg') }}"
                    alt="Register Image" class="w-full h-full object-cover rounded-lg">
            </div>
        </div>
    </div>
@endsection

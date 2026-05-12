@extends('layouts.master')

@section('title', 'admin Dashboard')

@section('content')

<header class="bg-white border-b border-gray-100 px-8 py-5 flex justify-between items-center sticky top-0 z-30">
            <div>
                <h1 class="text-xl font-bold text-gray-800">لوحة التحكم</h1>
                <p class="text-xs text-gray-400 mt-1">مرحباً بك مجدداً، {{ auth()->user()->name }} 👋</p>
            </div>

            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-400 hover:bg-gray-50 rounded-xl relative">
                    <span class="absolute top-2 left-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <img src="{{ asset('storage/'.auth()->user()->image) }}" class="w-10 h-10 rounded-xl object-cover border border-gray-100">
            </div>
        </header>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-gray-800">08</p>
                        <p class="text-sm text-gray-400 font-medium">كورس مسجل</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-orange-50 text-orange-500 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-gray-800">14</p>
                        <p class="text-sm text-gray-400 font-medium">ساعة تعليمية</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 bg-green-50 text-green-500 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-black text-gray-800">03</p>
                        <p class="text-sm text-gray-400 font-medium">شهادات منجزة</p>
                    </div>
                </div>
            </div>

            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-lg font-bold text-gray-800">تابع التعلم</h2>
                <a href="#" class="text-indigo-600 text-sm font-bold hover:underline">مشاهدة الكل</a>
            </div>


        </div>

@endsection

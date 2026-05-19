@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('content')
<div class="min-h-screen bg-[#f8f9fa] p-4 lg:p-10" dir="rtl">
    <header class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 family-cairo">لوحة التحكم الإدارية 🛡️</h1>
        <p class="text-gray-500 mt-1">مرحباً بك مجدداً، إليك ملخص نشاط المنصة بالكامل.</p>
    </header>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <x-success-component />
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100 transition-transform hover:scale-105">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="text-green-500 text-xs font-bold bg-green-50 px-2 py-1 rounded-lg">+12%</span>
            </div>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">إجمالي المستخدمين</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $total_users ?? 0 }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100 transition-transform hover:scale-105">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">إجمالي الكورسات</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $total_courses ?? 0 }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100 transition-transform hover:scale-105">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">إجمالي التسجيلات</p>
            <h3 class="text-2xl font-black text-gray-800">{{ $total_enrollments ?? 0 }}</h3>
        </div>

        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-gray-100 transition-transform hover:scale-105">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-xl">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
            </div>
            <p class="text-gray-400 font-bold text-xs uppercase tracking-widest">إجمالي الأرباح</p>
            <h3 class="text-2xl font-black text-gray-800">${{ number_format($total_revenue ?? 0, 2) }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">أحدث المسجلين</h2>
                <a href="#" class="text-indigo-600 text-sm font-bold hover:underline">عرض الكل</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="p-4 text-gray-500 font-bold">المستخدم</th>
                            <th class="p-4 text-gray-500 font-bold">التاريخ</th>
                            <th class="p-4 text-gray-500 font-bold">الدور</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- @foreach($recent_users as $user)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="p-4 font-semibold text-gray-700">{{ $user->name }}</td>
                            <td class="p-4 text-gray-500">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold {{ $user->role == 'admin' ? 'bg-red-100 text-red-600' : ($user->role == 'instructor' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach --}}
                            <tr></tr>
                                <td class="p-4 text-center" colspan="3">
                                    <p class="text-gray-400 italic">لا يوجد مستخدمين جدد حالياً.</p>
                                </td>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-[40px] shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-50 flex justify-between items-center">
                <h2 class="text-xl font-bold text-gray-800">أحدث الاشتراكات</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th class="p-4 text-gray-500 font-bold">الطالب</th>
                            <th class="p-4 text-gray-500 font-bold">الكورس</th>
                            <th class="p-4 text-gray-500 font-bold text-left">السعر</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        {{-- @foreach($recent_enrollments as $enrollment)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            <td class="p-4 font-semibold text-gray-700">{{ $enrollment->user->name }}</td>
                            <td class="p-4 text-indigo-600 font-medium">{{ $enrollment->course->title }}</td>
                            <td class="p-4 text-left font-bold text-gray-800">${{ $enrollment->price }}</td>
                        </tr>
                        @endforeach --}}
                            <tr></tr>
                                <td class="p-4 text-center" colspan="3">
                                    <p class="text-gray-400 italic">لا توجد اشتراكات جديدة حالياً.</p>
                                </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-indigo-900 rounded-[40px] p-8 text-white">
        <h2 class="text-xl font-bold mb-6">روابط سريعة للملحقات</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center gap-2 transition-all">
                <i class="fa-solid fa-user-gear text-xl"></i>
                <span class="text-sm font-bold">إدارة المستخدمين</span>
            </a>
            <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center gap-2 transition-all">
                <i class="fa-solid fa-layer-group text-xl"></i>
                <span class="text-sm font-bold">إدارة الكورسات</span>
            </a>
            <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center gap-2 transition-all">
                <i class="fa-solid fa-list-check text-xl"></i>
                <span class="text-sm font-bold">التصنيفات</span>
            </a>
            <a href="#" class="bg-white/10 hover:bg-white/20 p-4 rounded-2xl flex flex-col items-center gap-2 transition-all">
                <i class="fa-solid fa-gears text-xl"></i>
                <span class="text-sm font-bold">إعدادات النظام</span>
            </a>
        </div>
    </div>
</div>
@endsection

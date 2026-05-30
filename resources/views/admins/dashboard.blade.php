@extends('layouts.master')

@section('title', 'Admin Dashboard')
@section('content')
<div class="min-h-screen bg-[#f8f9fa] dark:bg-slate-800  text-zinc-800 dark:text-zinc-100 p-4 lg:p-10 font-sans transition-colors duration-300" dir="rtl">

    <header class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 dark:text-white family-cairo">لوحة التحكم الإدارية 🛡️</h1>
        <p class="text-gray-500 dark:text-zinc-400 mt-1">مرحباً بك مجدداً، إليك ملخص نشاط المنصة بالكامل.</p>
    </header>
        <x-success-component />
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-md p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800/80 shadow-sm transition-transform hover:scale-105 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-indigo-50 dark:bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center text-xl border border-indigo-100 dark:border-indigo-500/20 group-hover:bg-indigo-500 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-users"></i>
                </div>
                <span class="text-green-500 dark:text-emerald-400 text-xs font-bold bg-green-50 dark:bg-emerald-500/10 border border-green-200 dark:border-emerald-500/20 px-2 py-1 rounded-lg">+12%</span>
            </div>
            <p class="text-gray-400 dark:text-zinc-400 font-bold text-xs uppercase tracking-widest">إجمالي المستخدمين</p>
            <h3 class="text-2xl font-black text-gray-800 dark:text-white mt-1">{{ $total_users ?? 0 }}</h3>
        </div>

        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-md p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800/80 shadow-sm transition-transform hover:scale-105 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center text-xl border border-blue-100 dark:border-blue-500/20 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
            <p class="text-gray-400 dark:text-zinc-400 font-bold text-xs uppercase tracking-widest">إجمالي الكورسات</p>
            <h3 class="text-2xl font-black text-gray-800 dark:text-white mt-1">{{ $total_courses ?? 0 }}</h3>
        </div>

        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-md p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800/80 shadow-sm transition-transform hover:scale-105 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-purple-50 dark:bg-purple-500/10 text-purple-600 dark:text-purple-400 rounded-2xl flex items-center justify-center text-xl border border-purple-100 dark:border-purple-500/20 group-hover:bg-purple-500 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
            </div>
            <p class="text-gray-400 dark:text-zinc-400 font-bold text-xs uppercase tracking-widest">إجمالي التسجيلات</p>
            <h3 class="text-2xl font-black text-gray-800 dark:text-white mt-1">{{ $total_enrollments ?? 0 }}</h3>
        </div>

        <div class="bg-white dark:bg-zinc-900/50 backdrop-blur-md p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800/80 shadow-sm transition-transform hover:scale-105 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-2xl flex items-center justify-center text-xl border border-emerald-100 dark:border-emerald-500/20 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
            </div>
            <p class="text-gray-400 dark:text-zinc-400 font-bold text-xs uppercase tracking-widest">إجمالي الأرباح</p>
            <h3 class="text-2xl font-black text-gray-800 dark:text-white mt-1">${{ number_format($total_revenue ?? 0, 2) }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">

        <div class="bg-white dark:bg-zinc-900/30 backdrop-blur-md rounded-[40px] shadow-sm border border-gray-100 dark:border-zinc-800/80 overflow-hidden">
            <div class="p-6 border-b border-gray-50 dark:border-zinc-800/60 flex justify-between items-center bg-gray-50/30 dark:bg-zinc-900/20">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">أحدث المسجلين</h2>
                <a href="#" class="text-indigo-600 dark:text-indigo-400 text-sm font-bold hover:underline">عرض الكل</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-gray-50/50 dark:bg-zinc-900/60 text-gray-500 dark:text-zinc-400 border-b border-gray-100 dark:border-zinc-800/40">
                        <tr>
                            <th class="p-4 font-bold">المستخدم</th>
                            <th class="p-4 font-bold">التاريخ</th>
                            <th class="p-4 font-bold">الدور</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-zinc-800/40">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50/30 dark:hover:bg-zinc-800/20 transition-colors">
                            <td class="p-4 font-semibold text-gray-700 dark:text-zinc-200">{{ $user->name }}</td>
                            <td class="p-4 text-gray-500 dark:text-zinc-400">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider {{ $user->role == 'admin' ? 'bg-red-100 text-red-600 dark:bg-rose-500/10 dark:text-rose-400 border border-rose-200 dark:border-rose-500/20' : ($user->role == 'instructor' ? 'bg-blue-100 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400 border border-blue-200 dark:border-blue-500/20' : 'bg-gray-100 text-gray-600 dark:bg-zinc-700/30 dark:text-zinc-400 border border-gray-200 dark:border-zinc-700/20') }}">
                                    {{ strtoupper($user->role) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="p-4 text-center text-gray-400 dark:text-zinc-500 italic" colspan="3">
                                لا يوجد مستخدمين جدد حالياً.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white dark:bg-zinc-900/30 backdrop-blur-md rounded-[40px] shadow-sm border border-gray-100 dark:border-zinc-800/80 overflow-hidden">
            <div class="p-6 border-b border-gray-50 dark:border-zinc-800/60 flex justify-between items-center bg-gray-50/30 dark:bg-zinc-900/20">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">أحدث الاشتراكات</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm">
                    <thead class="bg-gray-50/50 dark:bg-zinc-900/60 text-gray-500 dark:text-zinc-400 border-b border-gray-100 dark:border-zinc-800/40">
                        <tr>
                            <th class="p-4 font-bold">الطالب</th>
                            <th class="p-4 font-bold">الكورس</th>
                            <th class="p-4 font-bold text-left">السعر</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 dark:divide-zinc-800/40">
                        @foreach($recent_enrollments as $enrollment)
                        <tr class="hover:bg-gray-50/30 dark:hover:bg-zinc-800/20 transition-colors">
                            {{-- حماية الكود من أخطاء الـ null السابقة --}}
                            <td class="p-4 text-gray-700 dark:text-zinc-200">{{ $enrollment->student->name ?? 'طالب محذوف' }}</td>
                            <td class="p-4 text-indigo-600 dark:text-indigo-400 font-medium">{{ $enrollment->course->title }}</td>
                            <td class="p-4 text-left font-bold text-gray-800 dark:text-zinc-100">${{ $enrollment->course->price }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="p-4 text-center text-gray-400 dark:text-zinc-500 italic" colspan="3">
                                لا توجد اشتراكات جديدة حالياً.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-indigo-900 via-indigo-950 to-slate-900 dark:from-zinc-900 dark:via-indigo-950/40 dark:to-zinc-900 rounded-[40px] p-8 text-white border border-indigo-950 dark:border-zinc-800/60 shadow-xl relative overflow-hidden">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-[80px] pointer-events-none"></div>
        <h2 class="text-xl font-bold mb-6">روابط سريعة للملحقات</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 relative z-10">
            <a href="#" class="bg-white/10 dark:bg-zinc-900/60 hover:bg-white/20 dark:hover:bg-indigo-600/10 p-4 rounded-2xl flex flex-col items-center gap-2 border border-white/5 dark:border-zinc-800 hover:border-white/20 dark:hover:border-indigo-500/40 transition-all duration-300 group">
                <i class="fa-solid fa-user-gear text-xl text-indigo-200 dark:text-zinc-400 group-hover:text-white dark:group-hover:text-indigo-400 transition-colors"></i>
                <span class="text-sm font-bold">إدارة المستخدمين</span>
            </a>
            <a href="#" class="bg-white/10 dark:bg-zinc-900/60 hover:bg-white/20 dark:hover:bg-indigo-600/10 p-4 rounded-2xl flex flex-col items-center gap-2 border border-white/5 dark:border-zinc-800 hover:border-white/20 dark:hover:border-indigo-500/40 transition-all duration-300 group">
                <i class="fa-solid fa-layer-group text-xl text-indigo-200 dark:text-zinc-400 group-hover:text-white dark:group-hover:text-indigo-400 transition-colors"></i>
                <span class="text-sm font-bold">إدارة الكورسات</span>
            </a>
            <a href="#" class="bg-white/10 dark:bg-zinc-900/60 hover:bg-white/20 dark:hover:bg-indigo-600/10 p-4 rounded-2xl flex flex-col items-center gap-2 border border-white/5 dark:border-zinc-800 hover:border-white/20 dark:hover:border-indigo-500/40 transition-all duration-300 group">
                <i class="fa-solid fa-list-check text-xl text-indigo-200 dark:text-zinc-400 group-hover:text-white dark:group-hover:text-indigo-400 transition-colors"></i>
                <span class="text-sm font-bold">التصنيفات</span>
            </a>
            <a href="#" class="bg-white/10 dark:bg-zinc-900/60 hover:bg-white/20 dark:hover:bg-indigo-600/10 p-4 rounded-2xl flex flex-col items-center gap-2 border border-white/5 dark:border-zinc-800 hover:border-white/20 dark:hover:border-indigo-500/40 transition-all duration-300 group">
                <i class="fa-solid fa-gears text-xl text-indigo-200 dark:text-zinc-400 group-hover:text-white dark:group-hover:text-indigo-400 transition-colors"></i>
                <span class="text-sm font-bold">إعدادات النظام</span>
            </a>
        </div>
    </div>
</div>
@endsection

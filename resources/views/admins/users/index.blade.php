@extends('layouts.master')

@section('title', 'إدارة المستخدمين')

@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-[#0f172a] text-gray-800 dark:text-white p-4 lg:p-10 font-sans transition-colors duration-300"
        dir="rtl">

        {{-- HEADER --}}
        <header class="mb-10">
            <h1 class="text-3xl font-black text-gray-800 dark:text-white family-cairo">إدارة الأعضاء والمستخدمين 🛡️</h1>
            <p class="text-gray-500 dark:text-slate-400 mt-1">التحكم في صلاحيات المستخدمين، تفقد حساباتهم وحالاتهم داخل
                المنصة.</p>
        </header>

        <x-success-component />

        {{-- TABLE CONTAINER --}}
        <div
            class="bg-white dark:bg-slate-800 rounded-[40px] border border-gray-100 dark:border-slate-700 shadow-sm overflow-hidden mb-6">

            {{-- TOP HEADER --}}
            <div
                class="p-8 border-b border-gray-100 dark:border-slate-700 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-black text-gray-800 dark:text-white mb-1">
                        قائمة المسجلين الحاليين
                    </h2>
                    <p class="text-gray-500 dark:text-slate-400 text-sm">تفاصيل الأدوار، أرقام الهواتف، وحالة الحسابات.</p>
                </div>

                <button
                    class="px-5 py-3 rounded-2xl bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-white font-bold hover:scale-105 transition-all">
                    <i class="fa-solid fa-user-plus ml-2"></i>
                    <a href="{{ route('admin.users.create') }}">
                        اضافة مستخدم
                    </a>

                </button>
            </div>

            {{-- THE TABLE --}}
            <div class="overflow-x-auto">
                <table class="w-full text-right">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                            <th class="p-6 text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                                المستخدم</th>
                            <th
                                class="p-6 text-center text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                                الهاتف</th>
                            <th
                                class="p-6 text-center text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                                الدور / الصلاحية</th>
                            <th
                                class="p-6 text-center text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                                الحالة</th>
                            <th
                                class="p-6 text-left text-xs uppercase tracking-[3px] text-gray-400 dark:text-slate-500 font-bold">
                                الإجراءات</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                        @forelse ($users as $user)
                            <tr>
                                {{-- User Info --}}
                                <td class="p-6 flex items-center gap-4 whitespace-nowrap">
                                    <a href="{{ route('admin.users.show' , $user) }}">
                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : asset('assets/default-avatar.jpg') }}"
                                            alt="{{ $user->name }}" class="w-12 h-12 rounded-lg object-cover">
                                    </a>

                                    <div>
                                        <p class="text-sm font-bold text-gray-800 dark:text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-slate-400 mt-0.5"
                                            style="user-select: all;">{{ $user->email }}</p>
                                    </div>
                                </td>

                                {{-- Phone --}}
                                <td class="p-6 text-center whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $user->phone }}</span>
                                </td>

                                {{-- Role Badges --}}
                                <td class="p-6 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-bold {{ $user->role == 'admin' ? 'bg-red-100 text-red-600' : ($user->role == 'instructor' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600') }}">
                                        @if ($user->role == 'admin')
                                            مدير
                                        @elseif($user->role == 'instructor')
                                            محاضر
                                        @else
                                            طالب
                                        @endif
                                    </span>
                                </td>

                                {{-- Status --}}
                                <td class="p-6 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-bold {{ $user->status == 'active' ? 'bg-green-100 text-green-600' : 'bg-amber-100 text-amber-600' }}">
                                        {{ $user->status == 'active' ? 'نشط' : 'معطل' }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="p-6 text-left flex items-center gap-3 whitespace-nowrap">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-bold transition-all">
                                        تعديل
                                    </a>

                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                        onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المستخدم نهائياً؟');"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-bold transition-all">
                                            حذف
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            {{-- EMPTY STATE --}}
                            <tr>
                                <td colspan="5" class="p-16 text-center">
                                    <div
                                        class="w-24 h-24 rounded-full bg-indigo-500/10 text-indigo-500 flex items-center justify-center mx-auto mb-6">
                                        <i class="fa-solid fa-users-slash text-4xl"></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-gray-800 dark:text-white mb-2">لا يوجد مستخدمين
                                        مسجلين</h3>
                                    <p class="text-gray-500 dark:text-slate-400">لم يقم أي عضو بالتسجيل في المنصة حتى الآن.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION LINKS --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>

    </div>
@endsection

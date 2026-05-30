@extends('layouts.master')
@section('title', 'تسجيل الدخول')
@section('content')

<div class="min-h-screen bg-white dark:bg-slate-900 mt-20 transition-colors duration-300">

    <div class="min-h-[calc(100vh-73px)] flex items-center justify-center p-6 relative overflow-hidden">

        <div class="absolute top-[-10%] right-[-5%] w-96 h-96 bg-indigo-100 dark:bg-indigo-900/30 rounded-full blur-[100px] opacity-60 pointer-events-none"></div>
        <div class="absolute bottom-[-10%] left-[-5%] w-80 h-80 bg-purple-100 dark:bg-purple-900/30 rounded-full blur-[100px] opacity-50 pointer-events-none"></div>

        <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 bg-white dark:bg-slate-800 rounded-[2rem] overflow-hidden shadow-2xl shadow-indigo-100 dark:shadow-slate-900 border border-gray-100 dark:border-slate-700 relative z-10 transition-colors duration-300">

            {{-- ══ Form ══ --}}
            <div class="p-10 md:p-12">
                <div class="text-right mb-8">
                    <p class="text-xs font-bold text-indigo-500 dark:text-indigo-400 tracking-widest mb-2">مرحباً بعودتك 👋</p>
                    <h2 class="text-3xl font-black text-slate-900 dark:text-white">تسجيل الدخول</h2>
                    <p class="text-slate-400 dark:text-slate-500 text-sm mt-2">أدخل بياناتك للوصول لحسابك</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 rounded-2xl p-4 mb-6 text-sm text-right">
                        @foreach ($errors->all() as $error)<p>• {{ $error }}</p>@endforeach
                    </div>
                @endif

                <form action="{{ route('auth.signin') }}" method="POST" class="space-y-5 text-right">
                    @csrf

                    <div class="space-y-1.5">
                        <label class="text-slate-600 dark:text-slate-300 text-sm font-bold block">البريد الإلكتروني</label>
                        <div class="relative">
                            <input type="email" name="email" required value="{{ old('email') }}" placeholder="example@email.com"
                                class="w-full bg-slate-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-4 py-3.5 text-slate-800 dark:text-slate-100 text-sm outline-none focus:border-indigo-400 dark:focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 dark:focus:ring-indigo-900/30 transition placeholder-slate-300 dark:placeholder-slate-500 pr-11">
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <div class="flex justify-between items-center">
                            <a href="#" class="text-xs text-indigo-500 dark:text-indigo-400 hover:text-indigo-700 font-semibold transition">نسيت كلمة المرور؟</a>
                            <label class="text-slate-600 dark:text-slate-300 text-sm font-bold">كلمة المرور</label>
                        </div>
                        <div class="relative">
                            <input type="password" name="password" required placeholder="••••••••"
                                class="w-full bg-slate-50 dark:bg-slate-700 border border-gray-200 dark:border-slate-600 rounded-2xl px-4 py-3.5 text-slate-800 dark:text-slate-100 text-sm outline-none focus:border-indigo-400 dark:focus:border-indigo-500 focus:ring-4 focus:ring-indigo-50 dark:focus:ring-indigo-900/30 transition placeholder-slate-300 dark:placeholder-slate-500 pr-11">
                            <div class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-2">
                        <label class="text-slate-500 dark:text-slate-400 text-sm font-semibold cursor-pointer">تذكرني</label>
                        <input type="checkbox" name="remember" class="w-4 h-4 accent-indigo-600 rounded cursor-pointer">
                    </div>

                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-indigo-200 dark:shadow-indigo-900/50 hover:-translate-y-0.5 transform duration-200 text-base">
                        دخول إلى حسابي
                    </button>

                    <div class="flex items-center gap-4 my-2">
                        <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
                        <span class="text-slate-300 dark:text-slate-600 text-xs font-semibold">أو</span>
                        <div class="flex-1 h-px bg-gray-100 dark:bg-slate-700"></div>
                    </div>

                    <p class="text-center text-slate-400 dark:text-slate-500 text-sm">
                        ليس لديك حساب؟
                        <a href="{{ route('auth.register') }}" class="text-indigo-600 dark:text-indigo-400 font-black hover:underline">سجل الآن مجاناً</a>
                    </p>
                </form>
            </div>

            {{-- ══ Visual panel ══ --}}
            <div class="hidden md:flex flex-col items-center justify-center relative overflow-hidden p-12 bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-slate-700 dark:to-slate-800 transition-colors duration-300">
                <div class="absolute top-[-10%] left-[-10%] w-56 h-56 bg-indigo-200/30 dark:bg-indigo-600/10 rounded-full blur-[60px] pointer-events-none"></div>
                <div class="relative z-10 text-center w-full">
                    <div class="relative inline-block mb-8">
                        <div class="w-36 h-36 bg-white dark:bg-slate-700 rounded-3xl shadow-xl flex items-center justify-center mx-auto border border-indigo-50 dark:border-slate-600">
                            <svg class="w-20 h-20 text-indigo-500 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="float absolute -bottom-3 -right-4 bg-white dark:bg-slate-700 rounded-2xl shadow-lg px-3 py-2 flex items-center gap-2 border border-gray-100 dark:border-slate-600">
                            <span class="text-lg">🔐</span>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200">حساب آمن</span>
                        </div>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-2">أهلاً بعودتك!</h2>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed mb-8">سجل دخولك وتابع رحلتك التعليمية من حيث توقفت</p>
                    <div class="space-y-3 text-right">
                        <div class="bg-white dark:bg-slate-700 rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-gray-100 dark:border-slate-600">
                            <div class="w-9 h-9 bg-indigo-100 dark:bg-indigo-900/50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <div><p class="text-xs text-slate-400 dark:text-slate-500">متاح لك</p><p class="text-sm font-bold text-slate-700 dark:text-slate-200">+500 دورة تدريبية</p></div>
                        </div>
                        <div class="bg-white dark:bg-slate-700 rounded-2xl p-4 flex items-center gap-3 shadow-sm border border-gray-100 dark:border-slate-600">
                            <div class="w-9 h-9 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div><p class="text-xs text-slate-400 dark:text-slate-500">اكسب</p><p class="text-sm font-bold text-slate-700 dark:text-slate-200">شهادات معتمدة</p></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

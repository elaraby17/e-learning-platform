@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
    <div class="mx-auto grid max-w-5xl grid-cols-1 items-stretch overflow-hidden rounded-3xl border border-slate-200 bg-surface shadow-card-lg md:grid-cols-2 dark:border-navy-border dark:bg-navy-surface">
        {{-- ══ النموذج ══ --}}
        <div class="p-8 sm:p-10 md:p-12">
            <p class="mb-2 text-xs font-extrabold tracking-widest text-brand-500 uppercase">مرحباً بعودتك</p>
            <h1 class="text-2xl font-extrabold text-ink sm:text-3xl dark:text-white">تسجيل الدخول</h1>
            <p class="mt-2 text-sm text-slate-400 dark:text-slate-500">أدخل بياناتك للوصول لحسابك</p>

            <form action="{{ route('auth.signin') }}" method="POST" class="mt-8 space-y-5">
                @csrf

                <x-input name="email" label="البريد الإلكتروني" type="email" required dir="ltr"
                    placeholder="example@email.com" icon="fa-solid fa-envelope" autocomplete="email" />

                <div>
                    <div class="mb-1.5 flex items-center justify-between">
                        <label for="password" class="form-label mb-0">كلمة المرور</label>
                        <span class="text-xs font-bold text-slate-400 dark:text-slate-500"
                            title="ميزة استرجاع كلمة المرور غير متاحة حالياً">نسيت كلمة المرور؟</span>
                    </div>

                    <x-input name="password" type="password" required placeholder="••••••••" dir="ltr"
                        autocomplete="current-password" icon="fa-solid fa-lock" />
                </div>

                <label class="flex cursor-pointer items-center justify-end gap-2">
                    <span class="text-sm font-bold text-slate-500 dark:text-slate-400">تذكرني</span>
                    <input type="checkbox" name="remember" value="1"
                        class="h-4 w-4 cursor-pointer rounded accent-brand-500">
                </label>

                <x-button type="submit" size="lg" block>دخول إلى حسابي</x-button>

                <div class="flex items-center gap-4">
                    <span class="h-px flex-1 bg-slate-200 dark:bg-navy-border"></span>
                    <span class="text-xs font-bold text-slate-300 dark:text-slate-600">أو</span>
                    <span class="h-px flex-1 bg-slate-200 dark:bg-navy-border"></span>
                </div>

                <p class="text-center text-sm text-slate-400 dark:text-slate-500">
                    ليس لديك حساب؟
                    <a href="{{ route('auth.register') }}"
                        class="font-extrabold text-brand-600 hover:underline dark:text-brand-400">سجل الآن مجاناً</a>
                </p>
            </form>
        </div>

        {{-- ══ اللوحة البصرية ══ --}}
        <div class="relative hidden flex-col items-center justify-center overflow-hidden bg-navy p-12 md:flex">
            <div class="absolute -top-16 -start-16 h-56 w-56 rounded-full bg-brand-500/20 blur-3xl"
                aria-hidden="true"></div>

            <div class="relative z-10 w-full text-center">
                <div class="relative mb-8 inline-block">
                    <span
                        class="mx-auto flex h-36 w-36 items-center justify-center rounded-3xl border border-brand-500/30 bg-navy-surface shadow-card">
                        <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة" class="h-20 w-20 rounded-2xl object-contain"
                            width="80" height="80">
                    </span>

                    <span
                        class="absolute -bottom-3 -end-4 flex items-center gap-2 rounded-2xl border border-navy-border bg-navy-surface px-3 py-2 shadow-card">
                        <i class="fa-solid fa-lock text-brand-400" aria-hidden="true"></i>
                        <span class="text-xs font-extrabold text-slate-200">حساب آمن</span>
                    </span>
                </div>

                <h2 class="mb-2 text-2xl font-extrabold text-white">أهلاً بعودتك!</h2>
                <p class="mb-8 text-sm leading-relaxed text-slate-400">
                    سجل دخولك وتابع رحلتك التعليمية من حيث توقفت
                </p>

                <div class="space-y-3 text-start">
                    <div class="flex items-center gap-3 rounded-2xl border border-navy-border bg-navy-surface p-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-brand-500/10">
                            <i class="fa-solid fa-graduation-cap text-brand-400" aria-hidden="true"></i>
                        </span>
                        <div>
                            <p class="text-xs text-slate-500">متاح لك</p>
                            <p class="text-sm font-extrabold text-slate-200">+500 دورة تدريبية</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 rounded-2xl border border-navy-border bg-navy-surface p-4">
                        <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-success-500/10">
                            <i class="fa-solid fa-certificate text-success-400" aria-hidden="true"></i>
                        </span>
                        <div>
                            <p class="text-xs text-slate-500">اكسب</p>
                            <p class="text-sm font-extrabold text-slate-200">شهادات معتمدة</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
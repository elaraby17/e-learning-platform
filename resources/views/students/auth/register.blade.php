@extends('layouts.app')

@section('title', 'إنشاء حساب')

@section('content')
    <div class="mx-auto grid max-w-5xl grid-cols-1 items-stretch overflow-hidden rounded-3xl border border-separator bg-surface shadow-card-lg md:grid-cols-5 dark:border-navy-border dark:bg-navy-surface">
        <div data-register-steps data-step="1" class="md:col-span-3">
            <div class="p-8 sm:p-10 md:p-12">
                <p class="mb-2 text-xs font-extrabold tracking-widest text-brand-500 uppercase">انضم إلينا مجاناً</p>
                <h1 class="text-2xl font-extrabold text-ink sm:text-3xl dark:text-white">إنشاء حساب جديد</h1>

                {{-- ══ مؤشر الخطوات ══ --}}
                <div class="my-8 flex items-center gap-3" role="group" aria-label="خطوات التسجيل">
                    <span data-step-dot="1"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-500 text-xs font-extrabold text-white transition">1</span>
                    <span data-step-line class="h-1 flex-1 rounded-full bg-default transition dark:bg-navy"></span>
                    <span data-step-dot="2"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-default text-xs font-extrabold text-slate-400 transition dark:bg-navy dark:text-slate-500">2</span>
                    <span data-step-line class="h-1 flex-1 rounded-full bg-default transition dark:bg-navy"></span>
                    <span data-step-dot="3"
                        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-default text-xs font-extrabold text-slate-400 transition dark:bg-navy dark:text-slate-500">3</span>
                </div>

                <form action="{{ route('auth.signup') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ══ الخطوة 1 ══ --}}
                    <div data-step-panel="1" class="space-y-5">
                        <div>
                            <p class="mb-1 text-xs font-extrabold tracking-widest text-brand-500 uppercase">
                                الخطوة 1 من 3
                            </p>
                            <h2 class="text-xl font-extrabold text-ink dark:text-white">البيانات الشخصية</h2>
                            <p class="mt-1 text-sm text-muted">أدخل معلوماتك الأساسية للبدء</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <x-input name="name" label="الاسم الكامل" required placeholder="محمد أحمد" icon="fa-solid fa-user" />

                            <x-input name="phone" label="رقم الهاتف" required placeholder="01XXXXXXXXX" dir="ltr"
                                icon="fa-solid fa-phone" />
                        </div>

                        <x-input name="email" label="البريد الإلكتروني" type="email" required
                            placeholder="example@email.com" dir="ltr" icon="fa-solid fa-envelope" />

                        <div class="pt-2">
                            <x-button type="button" block data-step-next>
                                التالي <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                            </x-button>
                        </div>
                    </div>

                    {{-- ══ الخطوة 2 ══ --}}
                    <div data-step-panel="2" class="hidden space-y-5">
                        <div>
                            <p class="mb-1 text-xs font-extrabold tracking-widest text-brand-500 uppercase">
                                الخطوة 2 من 3
                            </p>
                            <h2 class="text-xl font-extrabold text-ink dark:text-white">عن نفسك</h2>
                            <p class="mt-1 text-sm text-muted">أخبرنا أكثر عن شخصيتك</p>
                        </div>

                        <x-radio-group name="gender" label="النوع" :options="['male' => 'ذكر', 'female' => 'أنثى']" />

                        <x-file-field label="الصورة الشخصية" for="image" colspan="">
                            <input type="file" name="image" id="image" accept="image/*"
                                class="block w-full cursor-pointer text-xs font-bold text-slate-500 file:me-3 file:min-h-9 file:rounded-lg file:border-0 file:bg-brand-50 file:px-3 file:text-xs file:font-extrabold file:text-brand-700 transition hover:file:bg-brand-100 dark:text-slate-400 dark:file:bg-brand-500/10 dark:file:text-brand-300 dark:hover:file:bg-brand-500/20" />
                        </x-file-field>

                        <x-textarea name="bio" label="نبذة مختصرة عنك" rows="3" placeholder="اكتب شيئاً عن نفسك..." />

                        <div class="flex gap-3 pt-2">
                            <x-button type="button" variant="secondary" class="flex-1" data-step-prev>
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i> السابق
                            </x-button>

                            <x-button type="button" class="flex-[2]" data-step-next>
                                التالي <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
                            </x-button>
                        </div>
                    </div>

                    {{-- ══ الخطوة 3 ══ --}}
                    <div data-step-panel="3" class="hidden space-y-5">
                        <div>
                            <p class="mb-1 text-xs font-extrabold tracking-widest text-brand-500 uppercase">
                                الخطوة 3 من 3
                            </p>
                            <h2 class="text-xl font-extrabold text-ink dark:text-white">تأمين الحساب</h2>
                            <p class="mt-1 text-sm text-muted">
                                اختر كلمة مرور قوية لحماية حسابك
                            </p>
                        </div>

                        <x-input name="password" label="كلمة المرور" type="password" required placeholder="••••••••"
                            dir="ltr" autocomplete="new-password" icon="fa-solid fa-lock" />

                        <x-input name="password_confirmation" label="تأكيد كلمة المرور" type="password" required
                            placeholder="••••••••" dir="ltr" autocomplete="new-password" icon="fa-solid fa-lock" />

                        <p
                            class="flex items-start gap-2 rounded-2xl border border-warning-200 bg-warning-50 p-4 text-xs leading-relaxed font-bold text-warning-700 dark:border-warning-500/30 dark:bg-warning-500/10 dark:text-warning-400">
                            <i class="fa-solid fa-triangle-exclamation mt-0.5" aria-hidden="true"></i>
                            يجب أن تكون كلمة المرور 8 أحرف على الأقل وتحتوي على أحرف وأرقام
                        </p>

                        <div class="flex gap-3 pt-2">
                            <x-button type="button" variant="secondary" class="flex-1" data-step-prev>
                                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i> السابق
                            </x-button>

                            <x-button type="submit" variant="success" class="flex-[2]" icon="fa-solid fa-check">
                                إنشاء الحساب
                            </x-button>
                        </div>
                    </div>
                </form>

                <p class="mt-6 text-center text-sm text-muted">
                    لديك حساب بالفعل؟
                    <a href="{{ route('auth.login') }}"
                        class="font-extrabold text-brand-600 hover:underline dark:text-brand-400">تسجيل الدخول</a>
                </p>
            </div>
        </div>

        {{-- ══ اللوحة البصرية ══ --}}
        <div class="relative hidden flex-col items-center justify-center overflow-hidden bg-navy p-10 md:col-span-2 md:flex">
            <div class="absolute -top-10 -start-10 h-56 w-56 rounded-full bg-brand-500/20 blur-3xl" aria-hidden="true"></div>

            <div class="relative z-10 w-full text-center">
                <div class="relative mb-7 inline-block">
                    <span
                        class="mx-auto flex h-32 w-32 items-center justify-center rounded-3xl border border-brand-500/30 bg-navy-surface shadow-card">
                        <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة" class="h-16 w-16 rounded-2xl object-contain"
                            width="64" height="64">
                    </span>

                    <span
                        class="absolute -bottom-3 -end-5 flex items-center gap-2 rounded-2xl border border-navy-border bg-navy-surface px-3 py-2 shadow-card">
                        <i class="fa-solid fa-graduation-cap text-brand-400" aria-hidden="true"></i>
                        <span class="text-xs font-extrabold text-slate-200">انضم الآن!</span>
                    </span>
                </div>

                <h2 class="mb-2 text-xl font-extrabold text-white">ابدأ رحلتك التعليمية</h2>
                <p class="mx-auto mb-7 max-w-[220px] text-sm leading-relaxed text-slate-400">
                    انضم لأكثر من 1000 طالب في Suez E-Learning
                </p>

                <div class="space-y-3 text-start">
                    @foreach ([
                        ['label' => 'البيانات الشخصية', 'sub' => 'الاسم والبريد والهاتف'],
                        ['label' => 'عن نفسك', 'sub' => 'الصورة والنوع والنبذة'],
                        ['label' => 'تأمين الحساب', 'sub' => 'كلمة المرور وتأكيدها'],
                    ] as $index => $registerStep)
                        <div
                            class="flex items-center gap-3 rounded-2xl border border-navy-border bg-navy-surface p-3.5">
                            <span
                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-brand-500/10 text-xs font-extrabold text-brand-400">
                                {{ $index + 1 }}
                            </span>
                            <div>
                                <p class="text-xs font-extrabold text-slate-200">{{ $registerStep['label'] }}</p>
                                <p class="text-xs text-muted">{{ $registerStep['sub'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
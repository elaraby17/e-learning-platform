<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="light" data-sidebar="expanded"
    data-role="{{ auth()->user()?->role ?? 'guest' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="color-scheme" content="light dark">

    <title>@yield('title', config('app.name', 'E Learning'))</title>

    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    {{-- Prevent theme / sidebar flash (FOUC) — runs before first paint.
         First visit follows the OS preference, later visits follow localStorage. --}}
    <script>
        (function() {
            var root = document.documentElement;
            var theme;
            var sidebar;

            try {
                theme = localStorage.getItem('theme');
                sidebar = localStorage.getItem('sidebar') === 'collapsed' ? 'collapsed' : 'expanded';
            } catch (e) {
                sidebar = 'expanded';
            }

            if (!theme) {
                theme = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ?
                    'dark' :
                    'light';
            }

            root.classList.toggle('dark', theme === 'dark');
            root.setAttribute('data-theme', theme);
            root.setAttribute('data-sidebar', sidebar);
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

@php
    $authUser = auth()->user();
    $validationErrors = $errors->any() ? $errors->all() : [];
    $statusMessages = [
        'profile-updated' => 'تم تحديث بياناتك بنجاح.',
        'password-updated' => 'تم تحديث كلمة المرور بنجاح.',
        'user-deleted' => 'تم حذف المستخدم بنجاح.',
    ];
    $statusFlash = session('status') ? $statusMessages[session('status')] ?? session('status') : null;
    $successFlash = session('success') ?: $statusFlash;

    /* صفحات الدخول/التسجيل للزوار: shell مركزي بالـ logo + تدرّج + blobs */
    $isGuestAuthPage = !$authUser && request()->routeIs('auth.*');
@endphp

<body class="min-h-screen transition-colors duration-200">
    @if ($isGuestAuthPage)
        {{-- ══ Guest auth shell · centered, gradient + blobs ══ --}}
        <div class="relative flex min-h-screen flex-col overflow-hidden bg-background">

            <div class="pointer-events-none absolute -top-32 -start-24 size-[28rem] rounded-full bg-brand-500/20 blur-3xl"
                aria-hidden="true"></div>
            <div class="pointer-events-none absolute top-1/3 -end-28 size-[26rem] rounded-full bg-violet-500/20 blur-3xl"
                aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 start-1/3 size-[24rem] rounded-full bg-sky-400/20 blur-3xl"
                aria-hidden="true"></div>

            <div class="relative z-10 flex items-center justify-between gap-4 px-4 py-5 sm:px-8">
                <a href="{{ url('/') }}" class="flex min-w-0 items-center gap-3" aria-label="الصفحة الرئيسية">
                    <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة"
                        class="size-11 shrink-0 rounded-xl object-cover shadow-brand">
                    <span class="truncate text-lg font-extrabold text-ink dark:text-mist">
                        {{ config('app.name', 'E Learning') }}
                    </span>
                </a>

                <button type="button" data-theme-toggle aria-pressed="true" aria-label="تبديل الوضع الداكن"
                    class="icon-box-lg border border-separator bg-surface/80 text-ink-muted backdrop-blur transition hover:border-accent hover:text-accent dark:border-navy-border dark:bg-navy-surface/80 dark:text-mist">
                    <i class="fa-solid fa-sun" data-theme-icon="sun" aria-hidden="true"></i>
                    <i class="fa-solid fa-moon hidden" data-theme-icon="moon" aria-hidden="true"></i>
                </button>
            </div>

            <main class="relative z-10 flex flex-1 items-center justify-center px-4 pb-12 sm:px-6">
                <div class="w-full">
                    @yield('content')
                </div>
            </main>
        </div>
    @else
        @if ($authUser)
            @include('layouts.partials.sidebar')
        @endif

        <div id="app-shell" class="app-shell flex min-h-screen flex-col">
            @include('layouts.partials.topbar')

            <main class="flex-1 px-4 pt-10 mt-20 pb-10 sm:px-6 lg:px-8 lg:pt-8">
                @yield('content')
            </main>

            @include('layouts.partials.footer')
        </div>
    @endif

    {{-- Flash + validation bridge consumed by resources/js/alerts.js --}}
    <div id="app-flash" hidden data-success="{{ $successFlash }}" data-error="{{ session('error') }}"
        data-warning="{{ session('warning') }}" data-info="{{ session('info') }}"
        data-errors="{{ $validationErrors ? json_encode($validationErrors, JSON_UNESCAPED_UNICODE) : '' }}"></div>

    @stack('scripts')
</body>

</html>

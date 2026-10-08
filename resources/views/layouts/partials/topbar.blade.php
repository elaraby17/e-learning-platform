@php
    $authUser = auth()->user();

    $roleLabel = match ($authUser?->role) {
        'admin' => 'مدير النظام',
        'instructor' => 'محاضر',
        default => 'طالب',
    };

    $avatarUrl = $authUser?->image
        ? (\Illuminate\Support\Str::startsWith($authUser->image, ['http://', 'https://'])
            ? $authUser->image
            : asset('storage/' . $authUser->image))
        : null;

    $initial = $authUser ? \Illuminate\Support\Str::of($authUser->name)->substr(0, 1)->upper() : '';

    $menuBox = 'absolute top-[calc(100%+0.5rem)] z-50 hidden overflow-hidden rounded-2xl border border-separator bg-surface shadow-2xl ring-1 ring-black/5 dark:border-white/10 dark:bg-navy-elevated dark:shadow-black/60 dark:ring-white/5';

    $btnBase = 'border border-separator bg-surface text-ink-muted transition hover:border-accent hover:bg-accent/5 hover:text-accent dark:border-navy-border dark:bg-navy-surface dark:hover:bg-accent/10';
@endphp

<header
    class="fixed top-0 left-0 right-0 z-50 w-full border-b border-separator/70 bg-surface/90 backdrop-blur-2xl dark:border-navy-border/70 dark:bg-navy/85">
    <div class="flex min-h-[72px] w-full items-center justify-between gap-4 px-4 sm:px-6 lg:px-8" dir="ltr">

        {{-- =====================================================
        LEFT — BRAND + THEME
        ====================================================== --}}
        <div class="flex shrink-0 items-center gap-3">

            {{-- Drawer (mobile / tablet) --}}
            @if ($authUser)
                <button type="button" data-drawer-open aria-expanded="false" aria-controls="app-sidebar-drawer"
                    aria-label="فتح القائمة الجانبية"
                    class="icon-box {{ $btnBase }} lg:hidden">
                    <i class="fa-solid fa-bars text-sm" aria-hidden="true"></i>
                </button>
            @endif

            {{-- BRAND --}}
            @if (!$authUser)
            <a href="{{ url('/') }}" class="group flex items-center gap-3 rounded-2xl py-1.5"
                aria-label="{{ config('app.name', 'DevCraft') }}">

                <span
                    class="bg-accent-gradient relative flex size-10 shrink-0 items-center justify-center overflow-hidden rounded-xl shadow-accent transition duration-300 group-hover:scale-105">
                    <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة"
                        class="relative z-10 h-full w-full object-cover">
                </span>

                <span class="hidden flex-col leading-none sm:flex">
                    <span class="text-[15px] font-black tracking-tight text-ink dark:text-mist">
                        {{ config('app.name', 'DevCraft') }}
                    </span>
                    <span class="mt-1 text-[9px] font-bold uppercase tracking-[0.18em] text-ink-muted">
                        E-LEARNING PLATFORM
                    </span>
                </span>
            </a>
            @else
            <a href="{{ route('student.home') }}" class="group flex items-center gap-3 rounded-2xl py-1.5"
                aria-label="{{ config('app.name', 'DevCraft') }}">

                <span
                    class="bg-accent-gradient relative flex size-10 shrink-0 items-center justify-center overflow-hidden rounded-xl shadow-accent transition duration-300 group-hover:scale-105">
                    <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة"
                        class="relative z-10 h-full w-full object-cover">
                </span>

                <span class="hidden flex-col leading-none sm:flex">
                    <span class="text-[15px] font-black tracking-tight text-ink dark:text-mist">
                        {{ config('app.name', 'DevCraft') }}
                    </span>
                    <span class="mt-1 text-[9px] font-bold uppercase tracking-[0.18em] text-ink-muted">
                        E-LEARNING PLATFORM
                    </span>
                </span>
            </a>
            @endif


            {{-- THEME TOGGLE --}}
            <button type="button" data-theme-toggle aria-pressed="false" aria-label="تبديل الوضع الداكن"
                class="group relative flex size-10 shrink-0 items-center justify-center overflow-hidden rounded-xl {{ $btnBase }}">

                <i class="fa-solid fa-sun absolute text-sm text-amber-500 transition-all duration-500 ease-out dark:-rotate-90 dark:scale-0 dark:opacity-0"
                    aria-hidden="true"></i>

                <i class="fa-solid fa-moon absolute rotate-90 scale-0 text-sm text-violet-300 opacity-0 transition-all duration-500 ease-out dark:rotate-0 dark:scale-100 dark:opacity-100"
                    aria-hidden="true"></i>
            </button>
        </div>

        {{-- =====================================================
        RIGHT — ACTIONS
        ====================================================== --}}
        <div class="flex shrink-0 items-center gap-2" dir="rtl">

            @auth
                {{-- USER --}}
                <div class="relative">
                    <button type="button" data-user-menu-trigger aria-controls="app-user-menu" aria-expanded="false"
                        aria-haspopup="true" aria-label="قائمة المستخدم"
                        class="group flex min-h-10 items-center gap-2 rounded-xl px-1.5 sm:px-2.5 {{ $btnBase }} dark:hover:border-accent/50">

                        <span
                            class="bg-accent-gradient relative flex size-8 shrink-0 items-center justify-center overflow-hidden rounded-lg text-xs font-black text-white">
                            {{ $initial }}
                            @if ($avatarUrl)
                                <img src="{{ $avatarUrl }}" alt="{{ $authUser->name }}"
                                    class="absolute inset-0 h-full w-full object-cover" loading="lazy"
                                    data-img-fallback>
                            @endif
                        </span>

                        <span class="hidden text-start sm:block">
                            <span class="block max-w-28 truncate text-xs font-black text-ink dark:text-mist">
                                {{ $authUser->name }}
                            </span>
                            <span class="mt-0.5 block text-[9px] font-bold text-ink-muted">
                                {{ $roleLabel }}
                            </span>
                        </span>

                        <i class="fa-solid fa-chevron-down hidden text-[9px] text-ink-muted transition sm:block"
                            aria-hidden="true"></i>
                    </button>

                    {{-- USER MENU --}}
                    <div id="app-user-menu" data-user-menu dir="ltr" class="{{ $menuBox }} -end-3 w-72 sm:end-0">

                        <div
                            class="flex items-center gap-3 border-b border-separator bg-canvas/60 p-4 dark:border-white/10 dark:bg-white/5">
                            <span
                                class="bg-accent-gradient relative flex size-11 shrink-0 items-center justify-center overflow-hidden rounded-xl text-sm font-black text-white">
                                {{ $initial }}
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrl }}" alt="{{ $authUser->name }}"
                                        class="absolute inset-0 h-full w-full object-cover" loading="lazy"
                                        data-img-fallback>
                                @endif
                            </span>

                            <div class="min-w-0">
                                <p class="truncate text-sm font-black text-ink dark:text-mist">
                                    {{ $authUser->name }}
                                </p>
                                <p class="mt-1 truncate text-[10px] font-bold text-ink-muted">
                                    {{ $authUser->email }}
                                </p>
                            </div>
                        </div>

                        <div class="p-2">
                            @if (Route::has('profile.show'))
                                <a href="{{ route('profile.show') }}"
                                    class="flex min-h-11 items-center gap-3 rounded-xl px-3 text-sm font-bold text-ink-muted transition hover:bg-canvas hover:text-ink dark:hover:bg-white/5 dark:hover:text-mist">
                                    <span class="icon-box bg-brand-500/10 text-brand-500">
                                        <i class="fa-solid fa-user text-xs" aria-hidden="true"></i>
                                    </span>
                                    الملف الشخصي
                                </a>
                            @endif

                            @if (Route::has('logout'))
                                <form method="POST" action="{{ route('logout') }}" data-confirm-logout>
                                    @csrf
                                    <button type="submit"
                                        class="flex min-h-11 w-full items-center gap-3 rounded-xl px-3 text-sm font-bold text-rose-600 transition hover:bg-rose-500/10 dark:text-rose-400">
                                        <span class="icon-box bg-rose-500/10 text-rose-500">
                                            <i class="fa-solid fa-right-from-bracket text-xs" aria-hidden="true"></i>
                                        </span>
                                        تسجيل الخروج
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                                {{-- NOTIFICATIONS --}}
                <div class="relative">
                    <button type="button" data-notifications-toggle aria-expanded="false"
                        aria-controls="app-notifications" aria-label="الإشعارات"
                        class="icon-box relative {{ $btnBase }}">

                        <i class="fa-solid fa-bell text-sm" aria-hidden="true"></i>

                        <span
                            class="absolute -end-1 -top-1 flex size-4 items-center justify-center rounded-full bg-rose-500 text-[8px] font-black text-white ring-2 ring-surface dark:ring-navy">
                            3
                        </span>
                    </button>

                    {{-- NOTIFICATIONS MENU --}}
                    <div id="app-notifications" data-notifications-menu dir="ltr"
                        class="{{ $menuBox }} -end-14 w-[min(20rem,calc(100vw-2rem))] sm:end-0 sm:w-80">

                        <div
                            class="flex items-center justify-between border-b border-separator p-4 dark:border-white/10">
                            <div>
                                <p class="text-sm font-black text-ink dark:text-mist">الإشعارات</p>
                                <p class="mt-1 text-[10px] font-bold text-ink-muted">آخر التحديثات</p>
                            </div>

                            <span
                                class="rounded-full bg-rose-500/10 px-2.5 py-1 text-[10px] font-black text-rose-600 dark:bg-rose-500/20 dark:text-rose-300">
                                3 جديد
                            </span>
                        </div>

                        <div class="p-2">
                            @foreach ([
                                ['icon' => 'fa-user-plus', 'title' => 'تسجيل جديد في كورسك', 'time' => 'منذ 5 دقائق', 'color' => 'text-emerald-500 bg-emerald-500/10 dark:bg-emerald-500/15'],
                                ['icon' => 'fa-star', 'title' => 'تقييم جديد على كورسك', 'time' => 'منذ ساعة', 'color' => 'text-amber-500 bg-amber-500/10 dark:bg-amber-500/15'],
                                ['icon' => 'fa-certificate', 'title' => 'تم إصدار شهادتك', 'time' => 'أمس', 'color' => 'text-brand-500 bg-brand-500/10 dark:bg-brand-500/20'],
                            ] as $notification)
                                <div
                                    class="flex items-center gap-3 rounded-xl p-3 transition hover:bg-canvas dark:hover:bg-white/5">
                                    <span
                                        class="flex size-9 shrink-0 items-center justify-center rounded-xl {{ $notification['color'] }}">
                                        <i class="fa-solid {{ $notification['icon'] }} text-xs" aria-hidden="true"></i>
                                    </span>

                                    <div class="min-w-0">
                                        <p class="truncate text-xs font-extrabold text-ink dark:text-mist">
                                            {{ $notification['title'] }}
                                        </p>
                                        <p class="mt-1 text-[10px] font-bold text-ink-muted">
                                            {{ $notification['time'] }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                {{-- GUEST --}}
                @if (Route::has('auth.login'))
                    <a href="{{ route('auth.login') }}"
                        class="hidden min-h-10 items-center rounded-xl px-4 text-sm font-bold text-ink-muted transition hover:bg-canvas hover:text-ink sm:inline-flex dark:hover:bg-white/5 dark:hover:text-mist">
                        دخول
                    </a>
                @endif

                @if (Route::has('auth.register'))
                    <a href="{{ route('auth.register') }}"
                        class="bg-accent-gradient inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-5 text-sm font-black text-white shadow-accent transition hover:-translate-y-0.5 active:scale-[.98]">
                        <span class="hidden sm:inline">ابدأ الآن</span>
                        <span class="sm:hidden">تسجيل</span>
                        <i class="fa-solid fa-arrow-left text-xs" aria-hidden="true"></i>
                    </a>
                @endif
            @endauth
        </div>
    </div>
</header>

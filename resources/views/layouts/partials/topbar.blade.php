@php
    $authUser = auth()->user();
    $roleLabel = match ($authUser?->role) {
        'admin' => 'مدير النظام',
        'instructor' => 'محاضر',
        default => 'طالب',
    };
@endphp

<header
    class="sticky top-0 z-30 border-b border-slate-200/80 bg-surface/80 backdrop-blur-xl dark:border-navy-border dark:bg-navy-surface/80">
    <div class="flex min-h-16 items-center gap-2 px-4 sm:gap-3 sm:px-6 lg:px-8">
        {{-- Mobile / tablet: open the off-canvas drawer --}}
        @if ($authUser)
            <button type="button" data-drawer-open aria-expanded="false" aria-controls="app-sidebar-drawer"
                aria-label="فتح القائمة الجانبية"
                class="icon-box border border-slate-200 text-ink-muted transition hover:border-accent hover:text-accent lg:hidden dark:border-navy-border">
                <i class="fa-solid fa-bars text-lg" aria-hidden="true"></i>
            </button>
        @endif

        {{-- Brand (guest pages only) --}}
        @unless ($authUser)
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة"
                    class="h-10 w-10 rounded-xl object-cover">
                <span class="text-[15px] font-extrabold text-ink dark:text-mist">{{ config('app.name', 'E Learning') }}</span>
            </a>
        @endunless

        {{-- Page title (breadcrumbs live in <x-page-header>) --}}
        <div class="min-w-0 flex-1 px-1">
            <p class="truncate text-base font-extrabold text-ink sm:text-lg dark:text-mist">
                @yield('title', config('app.name', 'E Learning'))
            </p>
        </div>

        {{-- Search · full field on ≥md, icon-only button below it --}}
        <form role="search" aria-label="بحث في المنصة" data-search-form
            class="hidden items-center md:flex"
            onsubmit="return false;">
            <label for="app-search" class="sr-only">ابحث عن كورس أو مادة</label>
            <div class="relative">
                <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5 text-ink-muted"
                    aria-hidden="true">
                    <i class="fa-solid fa-magnifying-glass text-sm"></i>
                </span>
                <input id="app-search" name="q" type="search" placeholder="ابحث عن كورس…"
                    autocomplete="off"
                    class="form-control h-11 min-h-11 w-44 ps-10 lg:w-64">
            </div>
        </form>

        <button type="button" data-search-open aria-label="بحث"
            class="icon-box border border-slate-200 text-ink-muted transition hover:border-accent hover:text-accent md:hidden dark:border-navy-border">
            <i class="fa-solid fa-magnifying-glass text-sm" aria-hidden="true"></i>
        </button>

        {{-- Theme toggle --}}
        <button type="button" data-theme-toggle aria-pressed="true" aria-label="تبديل الوضع الداكن"
            class="icon-box border border-slate-200 text-ink-muted transition hover:border-accent hover:text-accent dark:border-navy-border">
            <i class="fa-solid fa-sun text-base" data-theme-icon="sun" aria-hidden="true"></i>
            <i class="fa-solid fa-moon hidden text-base" data-theme-icon="moon" aria-hidden="true"></i>
        </button>

        @auth
            {{-- Notifications · UI only (no backend endpoint) --}}
            <button type="button" data-notifications-toggle aria-expanded="false" aria-controls="app-notifications"
                aria-label="الإشعارات"
                class="icon-box relative border border-slate-200 text-ink-muted transition hover:border-accent hover:text-accent dark:border-navy-border">
                <i class="fa-solid fa-bell text-base" aria-hidden="true"></i>
                <span
                    class="absolute -top-1 -end-1 flex size-4 items-center justify-center rounded-full bg-rose-500 text-[9px] font-extrabold text-white"
                    aria-hidden="true">3</span>
            </button>

            <div id="app-notifications" data-notifications-menu
                class="absolute end-4 top-16 z-50 hidden w-80 overflow-hidden rounded-2xl border border-slate-200 bg-surface shadow-card dark:border-navy-border dark:bg-navy-surface sm:end-6 lg:end-8">
                <div class="flex items-center justify-between border-b border-slate-200 p-4 dark:border-navy-border">
                    <p class="text-sm font-extrabold text-ink dark:text-mist">الإشعارات</p>
                    <span class="rounded-full bg-rose-500/10 px-2 py-0.5 text-[11px] font-extrabold text-rose-600 dark:text-rose-400">
                        3 جديد
                    </span>
                </div>

                <ul class="max-h-80 divide-y divide-slate-100 overflow-y-auto dark:divide-navy-border/70">
                    @foreach ([
                        ['icon' => 'fa-solid fa-user-plus', 'tone' => 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-300', 'title' => 'تسجيل جديد في كورسك', 'time' => 'منذ 5 دقائق'],
                        ['icon' => 'fa-solid fa-star', 'tone' => 'bg-amber-500/10 text-amber-600 dark:text-amber-300', 'title' => 'تقييم جديد على كورسك', 'time' => 'منذ ساعة'],
                        ['icon' => 'fa-solid fa-certificate', 'tone' => 'bg-brand-500/10 text-brand-600 dark:text-brand-300', 'title' => 'تم إصدار شهادتك', 'time' => 'أمس'],
                    ] as $notification)
                        <li>
                            <div class="flex items-start gap-3 p-4 transition hover:bg-canvas dark:hover:bg-white/5">
                                <span class="icon-box {{ $notification['tone'] }}">
                                    <i class="{{ $notification['icon'] }} text-sm" aria-hidden="true"></i>
                                </span>
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-bold text-ink dark:text-mist">
                                        {{ $notification['title'] }}
                                    </p>
                                    <p class="mt-0.5 text-xs text-ink-muted">{{ $notification['time'] }}</p>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- User menu --}}
            <div class="relative shrink-0">
                <button type="button" data-user-menu-trigger aria-controls="app-user-menu" aria-expanded="false"
                    aria-haspopup="true" aria-label="قائمة المستخدم"
                    class="flex min-h-11 items-center gap-2 rounded-xl border border-slate-200 ps-1.5 pe-2 transition hover:border-accent hover:bg-canvas sm:pe-3 dark:border-navy-border">
                    <span class="bg-accent-gradient relative flex size-9 items-center justify-center overflow-hidden rounded-lg text-sm font-extrabold text-white">
                        <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                            {{ \Illuminate\Support\Str::of($authUser->name)->substr(0, 1)->upper() }}
                        </span>
                        @if ($authUser->image)
                            <img src="{{ \Illuminate\Support\Str::startsWith($authUser->image, ['http://', 'https://'])
                                ? $authUser->image
                                : asset('storage/' . $authUser->image) }}" alt="{{ $authUser->name }}"
                                class="relative h-full w-full object-cover" loading="lazy" data-img-fallback>
                        @endif
                    </span>
                    <span class="hidden max-w-[9rem] flex-col items-start sm:flex">
                        <span class="max-w-full truncate text-xs font-extrabold text-ink dark:text-mist">{{ $authUser->name }}</span>
                        <span class="max-w-full truncate text-xs font-bold text-ink-muted">{{ $roleLabel }}</span>
                    </span>
                    <i class="fa-solid fa-chevron-down hidden text-[10px] text-ink-muted sm:inline-block"
                        aria-hidden="true"></i>
                </button>

                <div id="app-user-menu" data-user-menu
                    class="absolute end-0 z-50 mt-2 hidden w-64 overflow-hidden rounded-2xl border border-slate-200 bg-surface shadow-card dark:border-navy-border dark:bg-navy-surface">
                    <div class="flex items-center gap-3 border-b border-slate-200 p-4 dark:border-navy-border">
                        <span class="bg-accent-gradient relative flex size-11 shrink-0 items-center justify-center overflow-hidden rounded-xl text-base font-extrabold text-white">
                            <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                                {{ \Illuminate\Support\Str::of($authUser->name)->substr(0, 1)->upper() }}
                            </span>
                            @if ($authUser->image)
                                <img src="{{ \Illuminate\Support\Str::startsWith($authUser->image, ['http://', 'https://'])
                                    ? $authUser->image
                                    : asset('storage/' . $authUser->image) }}" alt="{{ $authUser->name }}"
                                    class="relative h-full w-full object-cover" loading="lazy" data-img-fallback>
                            @endif
                        </span>
                        <div class="min-w-0">
                            <p class="truncate text-sm font-extrabold text-ink dark:text-mist">{{ $authUser->name }}</p>
                            <p class="truncate text-xs text-ink-muted">{{ $authUser->email }}</p>
                        </div>
                    </div>

                    <div class="p-2">
                        @if (Route::has('profile.show'))
                            <a href="{{ route('profile.show') }}"
                                class="flex min-h-11 items-center gap-3 rounded-xl px-3 text-sm font-bold text-ink-muted transition hover:bg-canvas hover:text-ink dark:hover:bg-white/5 dark:hover:text-mist">
                                <span class="icon-box bg-brand-500/10 text-brand-600 dark:text-brand-300">
                                    <i class="fa-solid fa-user text-sm" aria-hidden="true"></i>
                                </span>
                                الملف الشخصي
                            </a>
                        @endif

                        @if (Route::has('logout'))
                            <form method="POST" action="{{ route('logout') }}" data-confirm-logout>
                                @csrf
                                <button type="submit"
                                    class="flex min-h-11 w-full items-center gap-3 rounded-xl px-3 text-sm font-bold text-rose-600 transition hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-500/10">
                                    <span class="icon-box bg-rose-500/10 text-rose-600 dark:text-rose-300">
                                        <i class="fa-solid fa-right-from-bracket text-sm" aria-hidden="true"></i>
                                    </span>
                                    تسجيل الخروج
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @else
            @if (Route::has('auth.login'))
                <a href="{{ route('auth.login') }}"
                    class="inline-flex min-h-11 items-center rounded-xl px-3 text-sm font-bold text-ink-muted transition hover:bg-canvas hover:text-ink dark:hover:bg-white/5 dark:hover:text-mist">
                    دخول
                </a>
            @endif
            @if (Route::has('auth.register'))
                <a href="{{ route('auth.register') }}"
                    class="bg-accent-gradient inline-flex min-h-11 items-center rounded-xl px-4 text-sm font-extrabold text-white shadow-accent transition hover:-translate-y-0.5 hover:opacity-95 active:scale-[0.98]">
                    حساب جديد
                </a>
            @endif
        @endauth
    </div>
</header>
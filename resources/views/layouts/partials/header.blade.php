<header
    class="flex items-center justify-between px-8 py-4 bg-white dark:bg-slate-900 border-b border-gray-100 dark:border-slate-700 fixed top-0 left-0 right-0 z-50 shadow-sm transition-colors duration-300">

    {{-- ══ Logo (يمين) ══ --}}
    <div class="logo">
        <a href="#" class="flex items-center gap-3">
            <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo" class="w-10 h-10 object-contain rounded-xl">
            <span class="text-lg font-black text-indigo-700 dark:text-indigo-400 tracking-tight">Dev Craft</span>
        </a>
    </div>

    {{-- ══ Actions (شمال) ══ --}}
    <div class="flex items-center gap-3">

        {{-- Dark mode toggle --}}
        <button @click="$store.theme.toggle()"
            class="w-10 h-10 rounded-xl bg-default dark:bg-slate-800 text-muted hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400 transition flex items-center justify-center">
            {{-- Sun (shown in dark) --}}
            <svg x-show="$store.theme.dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
            </svg>
            {{-- Moon (shown in light) --}}
            <svg x-show="!$store.theme.dark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>

        @guest
            <a href="{{ route('auth.login') }}"
                class="text-muted hover:text-indigo-600 dark:hover:text-indigo-400 transition font-semibold text-sm">
                تسجيل دخول
            </a>
            <a href="{{ route('auth.register') }}"
                class="bg-indigo-600 text-white px-5 py-2.5 rounded-xl hover:bg-indigo-700 transition font-bold text-sm shadow-sm">
                إنشاء حساب
            </a>
        @endguest

        @auth
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-xs text-muted font-semibold leading-none mb-0.5">مرحباً،</p>
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200 leading-none">{{ auth()->user()->name }}
                    </p>
                </div>
                <img src="{{ auth()->user()->image
                    ? (filter_var(auth()->user()->image, FILTER_VALIDATE_URL)
                        ? auth()->user()->image
                        : asset('storage/' . auth()->user()->image))
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=6366f1&color=fff&bold=true' }}"
                    alt="{{ auth()->user()->name }}"
                    class="w-10 h-10 rounded-full object-cover border-2 border-indigo-100 dark:border-slate-700 shadow-sm">
                <div class="w-px h-6 bg-gray-200 dark:bg-slate-700"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-1.5 text-red-400 hover:text-red-600 font-bold text-sm transition">

                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        خروج
                    </button>
                </form>
            </div>
        @endauth

    </div>
</header>

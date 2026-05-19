<div x-data="{ open: true }" class="flex min-h-screen bg-slate-50 dark:bg-slate-900 mt-[73px] transition-colors duration-300" dir="rtl" style="font-family:'Cairo',sans-serif">

    {{-- ══ SIDEBAR ══ --}}
    <aside :class="open ? 'w-64' : 'w-20'"
        class="bg-white dark:bg-slate-800 border-l border-gray-100 dark:border-slate-700 flex flex-col transition-all duration-300 ease-in-out sticky top-[73px] h-[calc(100vh-73px)] shadow-sm flex-shrink-0">

        {{-- Header --}}
        <div class="p-5 flex items-center justify-between border-b border-gray-50 dark:border-slate-700">
            <a x-show="open" x-transition href="{{ route('student.home') }}" class="flex items-center gap-2 overflow-hidden">
                <div class="bg-indigo-600 p-1.5 rounded-lg flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <span class="text-sm font-black text-indigo-700 dark:text-indigo-400 whitespace-nowrap">E Learning</span>
            </a>
            <button @click="open = !open"
                class="p-2 rounded-xl bg-indigo-50 dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-slate-600 transition flex-shrink-0">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                </svg>
            </button>
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

            @if(auth()->user()->role == 'user')
                <a href="{{ route('student.home') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-2xl transition
                        {{ request()->routeIs('student.home') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 dark:shadow-indigo-900/50' : 'text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">الرئيسية</span>
                </a>
                <a href="{{ route('all-courses') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-2xl transition
                        {{ request()->routeIs('students.courses*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 dark:shadow-indigo-900/50' : 'text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">جميع الكورسات</span>
                </a>
                <a href="{{ route('courses') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-2xl transition
                        {{ request()->routeIs('student.courses*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 dark:shadow-indigo-900/50' : 'text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">كورساتي</span>
                </a>
            @endif

            @if(auth()->user()->role == 'instructor')
                <a href="{{ route('instructor.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-2xl transition
                        {{ request()->routeIs('instructor.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 dark:shadow-indigo-900/50' : 'text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">لوحة التحكم</span>
                </a>
            @endif

            @if(auth()->user()->role == 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-3 py-3 rounded-2xl transition
                        {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 dark:shadow-indigo-900/50' : 'text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                    <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">لوحة التحكم</span>
                </a>
            @endif

            <a href="{{ route('profile.show') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-2xl transition
                    {{ request()->routeIs('profile.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-100 dark:shadow-indigo-900/50' : 'text-slate-500 dark:text-slate-400 hover:bg-indigo-50 dark:hover:bg-slate-700 hover:text-indigo-600 dark:hover:text-indigo-400' }}">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">الملف الشخصي</span>
            </a>


            <a href="{{ route('logout') }}"
                class="flex items-center gap-3 px-3 py-3 rounded-2xl transition text-red-400 dark:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400">
                <svg class="h-5 w-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                <span x-show="open" x-transition class="text-sm font-semibold whitespace-nowrap">تسجيل خروج</span>
            </a>

        </nav>

        {{-- User card --}}
        <div class="p-4 border-t border-gray-100 dark:border-slate-700">
            <div class="flex items-center gap-3 p-3 bg-slate-50 dark:bg-slate-700/50 rounded-2xl">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()?->name ?? 'Guest') }}&background=6366f1&color=fff&bold=true"
                    class="w-9 h-9 rounded-xl object-cover flex-shrink-0">
                <div x-show="open" x-transition class="overflow-hidden flex-1">
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200 truncate">{{ auth()->user()?->name ?? 'زائر' }}</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 truncate">
                        @if(auth()->user()?->role == 'admin') مدير
                        @elseif(auth()->user()?->role == 'instructor') محاضر
                        @else طالب
                        @endif
                    </p>
                </div>
            </div>
        </div>

    </aside>

    {{-- ══ MAIN ══ --}}
    <main class="flex-1 p-8 min-w-0">
            @include('layouts.partials.header')
        <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl border border-gray-100 dark:border-slate-700 shadow-sm min-h-[calc(100vh-73px-4rem)] transition-colors duration-300">
            @yield('content')
        </div>
        @include('layouts.partials.footer')
    </main>

</div>

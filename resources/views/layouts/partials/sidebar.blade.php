<div x-data="{ open: true }" class="flex min-h-screen bg-gray-50 mt-20" dir="rtl">

    <aside :class="open ? 'w-64' : 'w-20'"
        class="bg-white border-l border-gray-100 flex flex-col transition-all duration-300 ease-in-out sticky top-0 h-screen shadow-sm">

        <div class="p-6 flex items-center justify-between">
            <span x-show="open" x-transition
                class="text-xl font-extrabold text-indigo-600 overflow-hidden whitespace-nowrap">
                <div class="logo flex items-center gap-2">
                    <a href="{{ route('student.home') }}" class="flex items-center gap-2">
                        <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo"
                            class="w-12 h-12 object-contain">
                    </a>
                </div>
            </span>
            <button @click="open = !open"
                class="p-2 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-2 mt-4">
            @if(auth()->user()->role == 'user')
            <a href="{{ route('student.home') }}"
                class="flex items-center p-3 text-white bg-indigo-600 rounded-2xl shadow-lg shadow-indigo-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span x-show="open" x-transition class="font-medium">الرئيسية</span>
            </a>

            <a href="#"
                class="flex items-center p-3 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span x-show="open" x-transition class="font-medium">كورساتي</span>
            </a>
            @endif

            @if(auth()->user()->role == 'instructor')

                  <a href="{{ route('instructor.dashboard') }}"
                class="flex items-center p-3 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.54 1.254 2.576 3.388 2.576 5.899v1.899c-.988-.899-1.988-1.798-3-2.697M7 14l-.846-.846a1 1 0 01-.293-.7V9a1 1 0 01 .293-.7l4 -4a1 1 0 01 .7-.293h4a1"
                </svg>
                <span x-show="open" x-transition class="font-medium">لوحة التحكم</span>
            </a>
            @endif

            @if(auth()->user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center p-3 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.54 1.254 2.576 3.388 2.576 5.899v1.899c-.988-.899-1.988-1.798-3-2.697M7 14l-.846-.846a1 1 0 01-.293-.7V9a1 1 0 01 .293-.7l4 -4a1 1 0 01 .7-.293h4a1"
                </svg>
                <span x-show="open" x-transition class="font-medium">لوحة التحكم</span>
            </a>
            @endif


            <a href="{{ route('profile.show') }}"
                class="flex items-center p-3 text-gray-500 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span x-show="open" x-transition class="font-medium">الملف الشخصي</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-50">
            <div class="flex items-center p-2 bg-gray-50 rounded-2xl">
                <img src="https://ui-avatars.com/api/?name={{ auth()->user()?->name ?? 'Guest' }}&background=6366f1&color=fff"
                    class="w-10 h-10 rounded-xl object-cover">
                <div x-show="open" x-transition class="mr-3 overflow-hidden">
                    <p class="text-sm font-bold text-gray-800 truncate">{{ auth()->user()?->name ?? 'زائر' }}</p>
                    <p class="text-xs text-gray-400 truncate">طالب</p>
                </div>
            </div>
        </div>
    </aside>

    <main class="flex-1 p-8">
        @include('layouts.partials.header')

        <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
            @yield('content')
        </div>

        @include('layouts.partials.footer')
    </main>
</div>

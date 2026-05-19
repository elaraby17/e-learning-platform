<footer class="bg-white dark:bg-slate-900 border-t border-gray-100 dark:border-slate-700 py-8 mt-12 transition-colors duration-300" dir="rtl">
    <div class="max-w-7xl mx-auto px-8 flex flex-col md:flex-row items-center justify-between gap-4">

        <a href="{{ route('student.home') }}" class="flex items-center gap-2">
            <div class="bg-indigo-600 p-1.5 rounded-lg">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="text-slate-700 dark:text-slate-200 font-black text-sm">{{ config('app.name') }}</span>
        </a>

        <p class="text-slate-400 dark:text-slate-500 text-sm text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }} &mdash; جميع الحقوق محفوظة
        </p>

        <a href="https://elaraby.com" target="_blank" rel="noopener noreferrer"
            class="flex items-center gap-1.5 text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 transition text-sm font-semibold">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
            </svg>
            Made by Elaraby
        </a>

    </div>
</footer>

@php
    $authUser = auth()->user();
    $userRole = $authUser?->role ?? 'student';
    $roleLabel = match ($userRole) {
        'admin' => 'مدير النظام',
        'instructor' => 'محاضر',
        default => 'طالب',
    };
    $roleIcon = match ($userRole) {
        'admin' => 'fa-solid fa-user-shield',
        'instructor' => 'fa-solid fa-chalkboard-user',
        default => 'fa-solid fa-user-graduate',
    };
    $homeRoute = match ($userRole) {
        'admin' => 'admin.dashboard',
        'instructor' => 'instructor.dashboard',
        default => 'student.home',
    };
    $menuPartial = match ($userRole) {
        'admin' => 'layouts.partials.menu-admin',
        'instructor' => 'layouts.partials.menu-instructor',
        default => 'layouts.partials.menu-student',
    };
    $homeUrl = Route::has($homeRoute) ? route($homeRoute) : url('/');

    $avatarUrl = match (true) {
        blank($authUser?->image) => null,
        \Illuminate\Support\Str::startsWith($authUser->image, ['http://', 'https://']) => $authUser->image,
        str_starts_with($authUser->image, '/') => $authUser->image,
        default => asset('storage/' . $authUser->image),
    };
@endphp

{{-- ══ Sidebar · desktop (fixed, collapsible) + mobile/tablet (off-canvas drawer) ══ --}}
<aside id="app-sidebar-drawer"
    class="app-sidebar fixed inset-y-0 start-0 z-50 flex flex-col border-e border-slate-200 bg-surface shadow-card transition-[width,transform] duration-200 ease-out dark:border-navy-border dark:shadow-none lg:translate-x-0"
    data-sidebar-drawer inert aria-label="القائمة الجانبية">

    {{-- Brand --}}
    <div class="flex h-16 shrink-0 items-center gap-3 border-b border-slate-200 px-4 dark:border-navy-border">
        <a href="{{ $homeUrl }}" class="flex min-w-0 items-center gap-3" aria-label="الصفحة الرئيسية">
            <img src="{{ asset('images/logo.png') }}" alt="شعار المنصة"
                class="size-10 shrink-0 rounded-xl object-cover shadow-brand">
            <span class="sidebar-label min-w-0 truncate text-[15px] font-extrabold text-ink dark:text-mist">
                {{ config('app.name', 'E Learning') }}
            </span>
        </a>

        <button type="button" data-drawer-close aria-label="إغلاق القائمة الجانبية"
            class="ms-auto inline-flex size-9 shrink-0 items-center justify-center rounded-xl text-ink-muted transition hover:bg-canvas hover:text-accent lg:hidden dark:hover:bg-white/5">
            <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-x-hidden overflow-y-auto px-3 py-4" aria-label="روابط التنقل">
        @include($menuPartial)
    </nav>

    {{-- Desktop collapse toggle --}}
    <div class="hidden shrink-0 border-t border-slate-200 px-3 py-3 lg:block dark:border-navy-border">
        <button type="button" data-sidebar-toggle aria-expanded="true" aria-label="طي القائمة الجانبية"
            class="flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-slate-200 text-ink-muted transition hover:border-accent hover:bg-canvas hover:text-accent dark:border-navy-border dark:hover:bg-brand-500/10">
            <i class="fa-solid fa-angles-right text-base" aria-hidden="true" data-sidebar-toggle-icon></i>
            <span class="sidebar-label text-sm font-bold">طي القائمة</span>
        </button>
    </div>

    {{-- User card + logout --}}
    <div class="shrink-0 border-t border-slate-200 p-3 dark:border-navy-border">
        <div class="surface-muted flex items-center gap-3 p-2.5">
            <span class="bg-accent-gradient relative flex size-10 shrink-0 items-center justify-center overflow-hidden rounded-xl text-sm font-extrabold text-white">
                <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                    {{ \Illuminate\Support\Str::of($authUser->name)->substr(0, 1)->upper() }}
                </span>
                @if ($avatarUrl)
                    <img src="{{ $avatarUrl }}" alt="{{ $authUser->name }}"
                        class="relative size-full object-cover" loading="lazy" data-img-fallback>
                @endif
            </span>

            <div class="sidebar-label min-w-0 flex-1">
                <p class="truncate text-sm font-extrabold text-ink dark:text-mist">{{ $authUser->name }}</p>
                <p class="mt-0.5 flex items-center gap-1.5 truncate text-xs font-bold text-ink-muted">
                    <i class="{{ $roleIcon }} text-[10px]" aria-hidden="true"></i>
                    {{ $roleLabel }}
                </p>
            </div>
        </div>

        <form method="POST" action="{{ Route::has('logout') ? route('logout') : '#' }}" data-confirm-logout
            class="mt-2 w-full">
            @csrf
            <button type="submit"
                class="flex min-h-11 w-full items-center justify-center gap-2 rounded-xl border border-rose-200 px-3 text-sm font-bold text-rose-600 transition hover:bg-rose-50 dark:border-rose-500/30 dark:text-rose-400 dark:hover:bg-rose-500/10">
                <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                <span class="sidebar-label">تسجيل الخروج</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile / tablet overlay --}}
<div class="fixed inset-0 z-40 bg-ink/60 backdrop-blur-[2px] lg:hidden" data-drawer-overlay aria-hidden="true"></div>

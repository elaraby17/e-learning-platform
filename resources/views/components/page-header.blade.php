@props([
    'title' => null,
    'description' => null,
    'icon' => null,
])

<header {{ $attributes->class(['mb-6 flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between']) }}>
    <div class="min-w-0">
        @hasSection('page-breadcrumb')
            <nav class="mb-2 flex flex-wrap items-center gap-1.5 text-sm font-bold text-ink-muted"
                aria-label="مسار التصفح">
                @yield('page-breadcrumb')
            </nav>
        @endif

        <div class="flex items-center gap-3">
            @if ($icon)
                <span class="icon-box-lg bg-accent-gradient text-white shadow-accent">
                    <i class="{{ $icon }}" aria-hidden="true"></i>
                </span>
            @endif
            <h1 class="text-2xl font-extrabold text-ink lg:text-3xl dark:text-mist">{{ $title }}</h1>
        </div>

        @if ($description)
            <p class="mt-2 max-w-2xl text-[15px] leading-relaxed text-ink-muted">{{ $description }}</p>
        @endif
    </div>

    @isset($actions)
        <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
    @endisset
</header>
@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'padded' => true,
])

<section {{ $attributes->class(['surface-card overflow-hidden']) }}>
    @if ($title || isset($actions))
        <header class="flex flex-col gap-3 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between dark:border-navy-border">
            <div class="flex items-start gap-3">
                @if ($icon)
                    <span class="icon-box bg-accent-gradient text-white shadow-accent">
                        <i class="{{ $icon }}" aria-hidden="true"></i>
                    </span>
                @endif
                <div>
                    <h2 class="text-lg font-extrabold text-ink dark:text-mist">{{ $title }}</h2>
                    @if ($description)
                        <p class="mt-0.5 text-sm text-ink-muted">{{ $description }}</p>
                    @endif
                </div>
            </div>

            @isset($actions)
                <div class="flex flex-wrap items-center gap-2">{{ $actions }}</div>
            @endisset
        </header>
    @endif

    <div class="{{ $padded ? 'p-5 sm:p-6' : '' }}">
        {{ $slot }}
    </div>

    @isset($footer)
        <footer class="border-t border-slate-200 bg-canvas px-5 py-3 dark:border-navy-border dark:bg-navy/40">
            {{ $footer }}
        </footer>
    @endisset
</section>
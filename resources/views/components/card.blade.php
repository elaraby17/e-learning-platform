@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'padded' => true,
])

{{-- HeroUI Card: surface + shadow-surface + radius-3xl (الكلاس .surface-card في app.css) --}}
<section {{ $attributes->class(['surface-card overflow-hidden']) }}>
    @if ($title || isset($actions))
        <header class="flex flex-col gap-3 border-b border-separator px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                @if ($icon)
                    <span class="icon-box">
                        <i class="{{ $icon }}" aria-hidden="true"></i>
                    </span>
                @endif
                <div>
                    <h2 class="text-base font-bold text-foreground">{{ $title }}</h2>
                    @if ($description)
                        <p class="mt-0.5 text-sm text-muted">{{ $description }}</p>
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
        <footer class="border-t border-separator bg-surface-secondary px-5 py-3">
            {{ $footer }}
        </footer>
    @endisset
</section>

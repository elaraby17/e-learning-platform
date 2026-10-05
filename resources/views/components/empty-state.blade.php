@props([
    'title' => null,
    'description' => null,
    'icon' => 'fa-solid fa-inbox',
    'dashed' => true,
])

<div {{ $attributes->class([
        'empty-state flex flex-col items-center justify-center px-6 py-14 text-center',
        $dashed ? 'rounded-3xl border-2 border-dashed border-separator' : '',
    ]) }}>
    {{-- أيقونة داخل دائرة soft --}}
    <span class="mb-4 flex size-16 items-center justify-center rounded-full bg-accent-soft text-accent-soft-foreground">
        <i class="{{ $icon }} text-2xl" aria-hidden="true"></i>
    </span>

    @if ($title)
        <h3 class="text-lg font-bold text-foreground">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="mt-2 max-w-sm text-[15px] leading-relaxed text-muted">{{ $description }}</p>
    @endif

    @if (! $slot->isEmpty() || isset($actions))
        <div class="mt-5 flex flex-wrap items-center justify-center gap-2">
            {{ $slot }}

            @isset($actions)
                {{ $actions }}
            @endisset
        </div>
    @endif
</div>

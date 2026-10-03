@props([
    'title' => null,
    'description' => null,
    'icon' => 'fa-solid fa-inbox',
    'dashed' => true,
])

<div {{ $attributes->class([
        'flex flex-col items-center justify-center px-6 py-14 text-center',
        $dashed ? 'rounded-2xl border-2 border-dashed border-slate-200 dark:border-navy-border' : '',
    ]) }}>
    {{-- أيقونة كبيرة داخل دائرة بتدرّج --}}
    <span class="bg-accent-gradient mb-4 flex size-20 items-center justify-center rounded-full text-white shadow-accent">
        <i class="{{ $icon }} text-3xl" aria-hidden="true"></i>
    </span>

    @if ($title)
        <h3 class="text-lg font-extrabold text-ink dark:text-mist">{{ $title }}</h3>
    @endif

    @if ($description)
        <p class="mt-2 max-w-sm text-[15px] leading-relaxed text-ink-muted">{{ $description }}</p>
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
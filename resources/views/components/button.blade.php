@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'icon' => null,
    'type' => 'submit',
    'disabled' => false,
    'block' => false,
    'loading' => false,
    'loadingText' => 'جارٍ الحفظ…',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 rounded-xl font-extrabold transition-all duration-200 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-60';

    /* primary = تدرّج لون الدور؛ والباقي من نفس الـ palette */
    $variants = [
        'primary' => 'bg-accent-gradient text-white shadow-accent hover:-translate-y-0.5 hover:opacity-95',
        'secondary' => 'border border-slate-300 bg-surface text-ink transition hover:border-accent hover:bg-canvas hover:text-accent dark:border-navy-border dark:bg-navy-surface dark:text-mist',
        'danger' => 'bg-rose-500 text-white shadow-brand hover:-translate-y-0.5 hover:bg-rose-600',
        'success' => 'bg-gradient-to-l from-emerald-500 to-sky-400 text-white shadow-glow-sky hover:-translate-y-0.5 hover:opacity-95',
        'ghost' => 'text-ink-muted hover:bg-canvas hover:text-accent dark:hover:bg-white/5',
        'outline-danger' => 'border border-rose-200 text-rose-600 hover:bg-rose-50 dark:border-rose-500/30 dark:text-rose-400 dark:hover:bg-rose-500/10',
    ];

    /* كل المقاسات ≥ 44px ارتفاع للّمس، والمraised ones تبقى متوسطة بصرياً */
    $sizes = [
        'sm' => 'min-h-10 px-3.5 text-sm',
        'md' => 'min-h-11 px-4 text-sm',
        'lg' => 'min-h-12 px-6 text-base',
    ];

    $attributes = $attributes->class([
        $base,
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
        'w-full' => $block,
        'cursor-wait opacity-80' => $loading,
    ]);
@endphp

@if ($href && ! $disabled && ! $loading)
    <a href="{{ $href }}" {{ $attributes }}>
        @if ($icon)<i class="{{ $icon }}" aria-hidden="true"></i>@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes }} @disabled($disabled || $loading)
        @if ($loading) aria-busy="true" @endif>
        @if ($loading)
            <i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
            {{ $loadingText }}
        @else
            @if ($icon)<i class="{{ $icon }}" aria-hidden="true"></i>@endif
            {{ $slot }}
        @endif
    </button>
@endif
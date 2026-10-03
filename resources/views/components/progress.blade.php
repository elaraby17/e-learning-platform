@props([
    'value' => 0,
    'label' => null,
    'tone' => 'accent',
    'size' => 'md',
    'showValue' => true,
])

@php
    $percentage = max(0, min(100, (float) $value));

    /* كل نبرة = زوج فئات (الخلفية + النص) موجود كـ classes literals */
    $tones = [
        'accent' => ['bg-canvas dark:bg-navy/70', 'bg-accent-gradient'],
        'brand' => ['bg-canvas dark:bg-navy/70', 'bg-gradient-to-l from-brand-500 to-violet-500'],
        'emerald' => ['bg-canvas dark:bg-navy/70', 'bg-gradient-to-l from-emerald-500 to-sky-400'],
        'sun' => ['bg-canvas dark:bg-navy/70', 'bg-gradient-to-l from-amber-500 to-coral-400'],
        'warm' => ['bg-canvas dark:bg-navy/70', 'bg-gradient-to-l from-coral-400 to-rose-500'],
        'sky' => ['bg-canvas dark:bg-navy/70', 'bg-gradient-to-l from-sky-400 to-brand-500'],
    ];

    [$trackClass, $barClass] = $tones[$tone] ?? $tones['accent'];

    $heights = ['sm' => 'h-1.5', 'md' => 'h-2.5', 'lg' => 'h-3.5'];
    $height = $heights[$size] ?? $heights['md'];
@endphp

<div {{ $attributes->class(['w-full']) }}>
    @if ($label || $showValue)
        <div class="mb-2 flex items-center justify-between gap-3 text-sm">
            @if ($label)
                <span class="font-bold text-ink dark:text-mist">{{ $label }}</span>
            @else
                <span></span>
            @endif

            @if ($showValue)
                <span class="font-extrabold text-ink dark:text-mist" dir="ltr">{{ round($percentage) }}%</span>
            @endif
        </div>
    @endif

    <div class="{{ $height }} w-full overflow-hidden rounded-full {{ $trackClass }}" role="progressbar"
        aria-valuenow="{{ round($percentage) }}" aria-valuemin="0" aria-valuemax="100"
        @if ($label) aria-label="{{ $label }}" @endif>
        <div class="{{ $height }} rounded-full {{ $barClass }} transition-[width] duration-500 ease-out"
            style="width: {{ $percentage }}%"></div>
    </div>
</div>

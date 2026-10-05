@props([
    'value' => 0,
    'label' => null,
    'tone' => 'accent',
    'size' => 'md',
    'showValue' => true,
])

@php
    $percentage = max(0, min(100, (float) $value));

    /* HeroUI ProgressBar: ألوان الـ fill = accent | success | warning | danger.
       الأسماء القديمة بتتحول لأقرب لون. */
    $tones = [
        'accent' => 'progress-bar--accent',
        'brand' => 'progress-bar--accent',
        'sky' => 'progress-bar--accent',
        'emerald' => 'progress-bar--success',
        'sun' => 'progress-bar--warning',
        'warm' => 'progress-bar--danger',
    ];
    $toneClass = $tones[$tone] ?? $tones['accent'];

    $sizes = ['sm' => 'progress-bar--sm', 'md' => 'progress-bar--md', 'lg' => 'progress-bar--lg'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->class(['progress-bar', $toneClass, $sizeClass]) }}
    role="progressbar" aria-valuenow="{{ round($percentage) }}" aria-valuemin="0" aria-valuemax="100"
    @if ($label) aria-label="{{ $label }}" @endif>

    @if ($label)
        <span data-slot="label" class="font-bold">{{ $label }}</span>
    @endif

    @if ($showValue)
        <span class="progress-bar__output font-bold" dir="ltr">{{ round($percentage) }}%</span>
    @endif

    <div class="progress-bar__track">
        <div class="progress-bar__fill" style="width: {{ $percentage }}%"></div>
    </div>
</div>

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
    /*
     * HeroUI Button: الكلاس الأساسي `.button` + modifier للنوع (`.button--primary` …).
     * الألوان بتتحكم فيها متغيرات --button-bg / --button-fg، فالنوع "success"
     * بنعمله بتغيير المتغيرات دي بس (HeroUI مفيهوش زرار success جاهز).
     */
    $variants = [
        'primary' => 'button--primary',
        'secondary' => 'button--secondary',
        'danger' => 'button--danger',
        'success' => 'button--primary [--button-bg:var(--success)] [--button-bg-hover:var(--success-hover)] [--button-bg-pressed:var(--success-hover)] [--button-fg:var(--success-foreground)]',
        'ghost' => 'button--ghost',
        'outline-danger' => 'button--danger-soft',
    ];

    $sizes = [
        'sm' => 'button--sm',
        'md' => '',
        'lg' => 'button--lg',
    ];

    /* font-bold: خط Almarai مفيهوش وزن 500 اللي HeroUI بيستخدمه */
    $attributes = $attributes->class([
        'button font-bold',
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? '',
        'button--full-width' => $block,
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
        @if ($loading) aria-busy="true" data-pending="true" @endif>
        @if ($loading)
            <i class="fa-solid fa-circle-notch fa-spin" aria-hidden="true"></i>
            {{ $loadingText }}
        @else
            @if ($icon)<i class="{{ $icon }}" aria-hidden="true"></i>@endif
            {{ $slot }}
        @endif
    </button>
@endif

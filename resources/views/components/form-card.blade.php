@props([
    'title' => null,
    'description' => null,
    'icon' => null,
    'submitLabel' => null,
    'cancelLabel' => 'إلغاء',
    'cancelHref' => null,
])

@php
    $submitLabel = $submitLabel ?? 'حفظ التغييرات';
@endphp

{{-- form-card · كارت واحد يضم كل حقول الفورم مع شريط حفظ sticky على الموبايل.
     لاحظ: وسم <form> و@csrf و@method تبقى في الصفحة نفسها (بدون تغيير). --}}
<div {{ $attributes->class(['surface-card overflow-hidden']) }}>
    @if ($title || $icon)
        <div class="flex items-center gap-3 border-b border-separator p-5">
            @if ($icon)
                <span class="icon-box">
                    <i class="{{ $icon }}" aria-hidden="true"></i>
                </span>
            @endif

            <div class="min-w-0">
                @if ($title)
                    <h2 class="text-base font-bold text-foreground">{{ $title }}</h2>
                @endif
                @if ($description)
                    <p class="mt-0.5 text-sm text-muted">{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif

    <div class="p-5 sm:p-6">
        {{ $slot }}
    </div>

    {{-- شريط الحفظ: sticky أسفل الشاشة على الموبايل --}}
    <div class="form-actions">
        @if ($cancelHref)
            <x-button type="button" variant="secondary" icon="fa-solid fa-xmark" :href="$cancelHref">
                {{ $cancelLabel }}
            </x-button>
        @endif

        <x-button type="submit" icon="fa-solid fa-floppy-disk">{{ $submitLabel }}</x-button>
    </div>
</div>

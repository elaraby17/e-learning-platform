@props([
    'label' => null,
    'hint' => null,
    'colspan' => 'md:col-span-2',
    'for' => null,
])

<div class="{{ $colspan }}">
    @if ($label)
        <span class="form-label">{{ $label }}</span>
    @endif

    {{ $slot }}

    @if ($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif
</div>

@if ($for && $errors->has($for))
    <p class="form-error md:col-span-2">
        <i class="fa-solid fa-circle-exclamation mt-0.5 text-[11px]" aria-hidden="true"></i>
        {{ $errors->first($for) }}
    </p>
@endif
@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'placeholder' => null,
    'hint' => null,
    'icon' => null,
    'required' => false,
    'dir' => null,
    'autocomplete' => null,
    'inputmode' => null,
    'useOld' => true,
    'suffix' => null,
    'wrapperClass' => '',
])

@php
    $hasError = $errors->has($name);
    $inputValue = $useOld ? old($name, $value) : $value;
@endphp

<div class="{{ $wrapperClass }}">
    @if ($label)
        <label for="{{ $name }}" class="form-label">
            {{ $label }}
            @if ($required)
                <span class="text-danger-500" aria-hidden="true">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if ($icon)
            <span class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3.5 text-sm text-muted"
                aria-hidden="true">
                <i class="{{ $icon }}"></i>
            </span>
        @endif

        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $inputValue }}"
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($required) required @endif
            @if ($dir) dir="{{ $dir }}" @endif
            @if ($autocomplete) autocomplete="{{ $autocomplete }}" @endif
            @if ($inputmode) inputmode="{{ $inputmode }}" @endif
            @class([
                'form-control',
                'ps-10' => $icon,
                'pe-14' => $suffix,
                'form-control-error' => $hasError,
            ])>
        @if ($suffix)
            <span
                class="pointer-events-none absolute inset-y-0 end-0 flex items-center pe-3.5 text-xs font-extrabold text-muted"
                aria-hidden="true">{{ $suffix }}</span>
        @endif
    </div>

    @if ($hint)
        <p class="form-hint">{{ $hint }}</p>
    @endif

    @error($name)
        <p class="form-error">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-[11px]" aria-hidden="true"></i>
            {{ $message }}
        </p>
    @enderror
</div>
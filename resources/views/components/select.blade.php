@props([
    'name',
    'label' => null,
    'hint' => null,
    'required' => false,
    'wrapperClass' => '',
])

@php
    $hasError = $errors->has($name);
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

    <select name="{{ $name }}" id="{{ $name }}" @if ($required) required @endif
        {{ $attributes->class(['form-control', 'form-control-error' => $hasError]) }}>
        {{ $slot }}
    </select>

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
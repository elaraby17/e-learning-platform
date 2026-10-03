@props([
    'name',
    'label' => null,
    'rows' => 3,
    'value' => null,
    'placeholder' => null,
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

    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
        @if ($placeholder) placeholder="{{ $placeholder }}" @endif
        @if ($required) required @endif
        {{ $attributes->class([
            'form-control resize-y',
            'form-control-error' => $hasError,
        ]) }}>{{ old($name, $value) }}</textarea>

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
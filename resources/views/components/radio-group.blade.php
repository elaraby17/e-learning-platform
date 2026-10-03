@props([
    'name',
    'label' => null,
    'options' => [],
    'value' => null,
    'hint' => null,
    'wrapperClass' => '',
])

@php
    $current = old($name, $value);
@endphp

<div class="{{ $wrapperClass }}">
    @if ($label)
        <span class="form-label">{{ $label }}</span>
    @endif

    <div class="flex flex-wrap gap-2">
        @foreach ($options as $optionValue => $optionLabel)
            <label
                class="inline-flex min-h-11 flex-1 cursor-pointer items-center justify-center gap-2 rounded-xl border border-slate-300 bg-slate-50 px-4 text-sm font-bold text-slate-600 transition has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50 has-[:checked]:text-brand-700 hover:border-brand-300 dark:border-navy-border dark:bg-navy/70 dark:text-slate-300 dark:has-[:checked]:border-brand-500 dark:has-[:checked]:bg-brand-500/10 dark:has-[:checked]:text-brand-200">
                <input type="radio" name="{{ $name }}" id="{{ $name }}-{{ $optionValue }}"
                    value="{{ $optionValue }}" @checked((string) $current === (string) $optionValue)
                    class="h-4 w-4 accent-brand-500">
                {{ $optionLabel }}
            </label>
        @endforeach
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
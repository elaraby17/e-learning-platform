@props([
    'name' => '',
    'image' => null,
    'size' => 'h-14 w-14',
    'rounded' => 'rounded-xl',
])

@php
    $initial = \Illuminate\Support\Str::of($name ?: '?')->substr(0, 1)->upper();

    $imageUrl = match (true) {
        blank($image) => null,
        \Illuminate\Support\Str::startsWith($image, ['http://', 'https://', 'data:']) => $image,
        str_starts_with($image, '/') => $image,
        default => asset('storage/' . $image),
    };
@endphp

<span {{ $attributes->class(['relative inline-flex shrink-0 bg-brand-500 font-extrabold text-white items-center justify-center overflow-hidden', $size, $rounded]) }}>
    <span class="absolute inset-0 flex items-center justify-center" aria-hidden="true">{{ $initial }}</span>
    @if ($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $name }}" class="relative h-full w-full object-cover" loading="lazy"
            data-img-fallback>
    @endif
</span>
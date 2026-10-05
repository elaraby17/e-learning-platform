@props([
    'name' => '',
    'image' => null,
    'size' => 'h-14 w-14',
    'rounded' => 'rounded-full',
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

{{-- HeroUI Avatar: .avatar + fallback (الحرف الأول) + image فوقه --}}
<span {{ $attributes->class(['avatar', $size, $rounded]) }}>
    <span class="avatar__fallback avatar__fallback--accent bg-accent-soft font-bold" aria-hidden="true">{{ $initial }}</span>
    @if ($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $name }}" class="avatar__image object-cover" loading="lazy"
            data-img-fallback>
    @endif
</span>

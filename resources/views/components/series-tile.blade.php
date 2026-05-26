@props([
    'series',
    'index' => 1,
    'frameCount' => null,
])

@php
    $count = $frameCount ?? $series->photos()->count();
    $counter = str_pad((string) $index, 2, '0', STR_PAD_LEFT);
    $aspect = $series->aspect_ratio ?: '4/3';
    $imageUrl = $series->cover_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($series->cover_image_path)
        : \App\Support\NativeFallbacks::seriesCoverUrl($series->slug);
    $alt = $series->cover_image_alt ?? "{$series->title} — cover image";
@endphp

<a href="{{ route('portfolio.show', $series) }}" class="tile" data-reveal-child>
    <div class="tile-media" style="aspect-ratio: {{ $aspect }};">
        <img
            src="{{ $imageUrl }}"
            alt="{{ $alt }}"
            loading="lazy"
            decoding="async"
        />
    </div>
    <div class="tile-meta">
        <span class="tile-count">{{ $counter }} &nbsp;·&nbsp; {{ $count }} {{ \Illuminate\Support\Str::plural('frame', $count) }}</span>
        <h3 class="tile-name">{{ $series->title }}</h3>
    </div>
</a>

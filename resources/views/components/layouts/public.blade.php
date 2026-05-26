@props([
    'title' => null,
    'description' => null,
    'canonical' => null,
    'ogTitle' => null,
    'ogDescription' => null,
    'ogImage' => null,
    'ogType' => 'website',
    'preloadImage' => null,
    'current' => null,
    'bodyClass' => null,
])

@php
    $resolvedTitle = $title
        ? "{$title} — {$profile->name}"
        : "{$profile->name} — {$profile->tagline}";
    $resolvedCanonical = $canonical ?? url()->current();
    $resolvedOgImage = $ogImage
        ?? ($profile->hero_image_path
            ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->hero_image_path)
            : null);
@endphp

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
        <meta name="theme-color" content="#0A0A0A" />
        <meta name="color-scheme" content="dark" />

        <x-site-icons />

        <title>{{ $resolvedTitle }}</title>
        @if ($description)
            <meta name="description" content="{{ $description }}" />
        @endif
        <link rel="canonical" href="{{ $resolvedCanonical }}" />

        <meta property="og:type" content="{{ $ogType }}" />
        <meta property="og:title" content="{{ $ogTitle ?? $resolvedTitle }}" />
        @if ($ogDescription ?? $description)
            <meta property="og:description" content="{{ $ogDescription ?? $description }}" />
        @endif
        @if ($resolvedOgImage)
            <meta property="og:image" content="{{ $resolvedOgImage }}" />
        @endif
        <meta property="og:url" content="{{ $resolvedCanonical }}" />
        <meta name="twitter:card" content="summary_large_image" />

        @if ($preloadImage)
            <link rel="preload" as="image" href="{{ $preloadImage }}" fetchpriority="high" />
        @endif

        {{ $head ?? '' }}

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script defer src="https://umami.shiroyuki.dev/script.js" data-website-id="4d400d8b-e9a8-48b7-ac04-41fcb72ff96a"></script>
        <script defer src="https://umami.shiroyuki.dev/recorder.js" data-website-id="4d400d8b-e9a8-48b7-ac04-41fcb72ff96a" data-sample-rate="0.15" data-mask-level="moderate" data-max-duration="300000"></script>
    </head>
    <body @class([$bodyClass])>
        <div class="grain" aria-hidden="true"></div>

        <x-nav :current="$current" />

        <main>
            {{ $slot }}
        </main>

        <x-footer />
    </body>
</html>

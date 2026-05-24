@php
    $iconUrl = url(config('site.icon', '/icon-sm.png'));
    $iconType = config('site.icon_type', 'image/png');
    $iconSizes = config('site.icon_sizes', '320x320');
    $themeColor = config('site.theme_color', '#0A0A0A');
    $applicationName = $profile->monogram ?? $profile->alternate_name ?? $profile->name ?? config('app.name');
@endphp

<link rel="icon" href="{{ $iconUrl }}" type="{{ $iconType }}" sizes="{{ $iconSizes }}" />
<link rel="shortcut icon" href="{{ $iconUrl }}" type="{{ $iconType }}" />
<link rel="apple-touch-icon" href="{{ $iconUrl }}" sizes="{{ $iconSizes }}" />
<link rel="apple-touch-icon-precomposed" href="{{ $iconUrl }}" />
<link rel="manifest" href="{{ url('/site.webmanifest') }}" />

<meta name="application-name" content="{{ $applicationName }}" />
<meta name="msapplication-TileImage" content="{{ $iconUrl }}" />
<meta name="msapplication-TileColor" content="{{ $themeColor }}" />
<meta name="msapplication-config" content="{{ url('/browserconfig.xml') }}" />

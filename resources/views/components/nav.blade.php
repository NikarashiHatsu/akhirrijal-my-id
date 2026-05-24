@props([
    'current' => null,
])

@php
    $links = [
        ['key' => 'home', 'label' => 'Home', 'href' => route('home')],
        ['key' => 'about', 'label' => 'About', 'href' => route('about')],
        ['key' => 'portfolio', 'label' => 'Portfolio', 'href' => route('portfolio.index')],
        ['key' => 'contact', 'label' => 'Contact', 'href' => route('contact.show')],
    ];

    $monogram = $profile->monogram ?? $profile->alternate_name ?? $profile->name;
@endphp

<header class="site-nav">
    <div class="container-wide flex items-center justify-between">
        <a href="{{ route('home') }}" class="nav-monogram" aria-label="{{ $monogram }} — Home">
            {{ $monogram }}<span class="dot">.</span>
        </a>

        <nav class="hidden md:flex items-center gap-10" aria-label="Primary">
            @foreach ($links as $link)
                <a
                    href="{{ $link['href'] }}"
                    class="nav-link"
                    @if ($current === $link['key']) aria-current="page" @endif
                >{{ $link['label'] }}</a>
            @endforeach
        </nav>

        @if ($profile->whatsapp_e164)
            <div class="hidden md:flex items-center gap-6">
                <a
                    href="https://wa.me/{{ $profile->whatsapp_e164 }}"
                    class="nav-link"
                    style="color: var(--accent)"
                    target="_blank"
                    rel="noopener noreferrer"
                    data-no-transition
                >+{{ $profile->whatsapp_e164 }} · {{ $profile->availability_status ?? 'Available' }}</a>
            </div>
        @endif

        <button class="menu-toggle md:hidden" data-menu-toggle aria-label="Open menu" aria-controls="mobile-menu">Menu</button>
    </div>

    <div class="mobile-menu" id="mobile-menu" data-mobile-menu role="dialog" aria-modal="true" aria-label="Site menu">
        <button class="menu-toggle menu-close" data-menu-close aria-label="Close menu">Close</button>
        @foreach ($links as $link)
            <a
                href="{{ $link['href'] }}"
                @if ($current === $link['key']) aria-current="page" @endif
            >{{ $link['label'] }}</a>
        @endforeach
    </div>
</header>

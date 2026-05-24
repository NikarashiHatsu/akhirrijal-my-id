@php
    $links = [
        ['label' => 'Home', 'href' => route('home')],
        ['label' => 'About', 'href' => route('about')],
        ['label' => 'Portfolio', 'href' => route('portfolio.index')],
        ['label' => 'Contact', 'href' => route('contact.show')],
    ];

    $footerBrand = $profile->monogram ?? $profile->alternate_name ?? $profile->name;
@endphp

<footer class="site-footer" data-reveal>
    <div class="container-wide">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 md:gap-8 items-start">
            <div>
                <a href="{{ route('home') }}" class="footer-brand block">{{ $footerBrand }}<span style="color: var(--accent)">.</span></a>
                <p class="mt-4 text-sm" style="color: var(--muted)">
                    {{ $profile->tagline ?? 'Documentary & outdoor photography.' }}<br />
                    Based in {{ $profile->location_city ?? 'Jakarta' }} · {{ $profile->availability_status ?? 'Available worldwide' }}.
                </p>
            </div>

            <nav class="flex flex-col gap-3 md:items-center" aria-label="Footer">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}" class="nav-link" style="font-size: 0.72rem">{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="flex flex-col gap-3 md:items-end">
                @forelse ($socialLinks as $social)
                    <a
                        class="link-underline text-sm"
                        href="{{ $social->url }}"
                        @if (! str_starts_with($social->url, 'mailto:'))
                            target="_blank"
                            rel="noopener noreferrer"
                        @endif
                        data-no-transition
                    >{{ $social->label }}</a>
                @empty
                    @if ($profile->email)
                        <a class="link-underline text-sm" href="mailto:{{ $profile->email }}" data-no-transition>{{ $profile->email }}</a>
                    @endif
                @endforelse
            </div>
        </div>

        <hr class="rule mt-14" />

        <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-3 text-xs" style="color: var(--muted-2); letter-spacing: 0.18em; text-transform: uppercase;">
            <span>&copy; <span data-year>{{ now()->year }}</span> {{ $profile->name }}. All rights reserved.</span>
            <span>{{ $profile->crafted_in_label ?? 'Crafted in Jakarta · Indonesia' }}</span>
        </div>
    </div>
</footer>

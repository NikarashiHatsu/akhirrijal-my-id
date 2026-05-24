@php
    $heroImage = $profile->hero_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->hero_image_path)
        : \App\Support\NativeFallbacks::HOME_HERO;

    $aboutPortrait = $profile->about_portrait_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->about_portrait_image_path)
        : \App\Support\NativeFallbacks::ABOUT_PORTRAIT;
@endphp

<x-layouts.public
    title="{{ $profile->name }} — {{ $profile->tagline ?? 'Documentary & Outdoor Photographer' }}"
    description="{{ $profile->name }} is a {{ $profile->location_city ?? 'Jakarta' }}-based freelance photographer specializing in street, human interest, landscape, and outdoor storytelling. Available worldwide for hospitality, cruise, and editorial assignments."
    :preload-image="$heroImage"
    current="home"
>
    <x-slot:head>
        <script type="application/ld+json">
            {!! json_encode([
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => $profile->name,
                'alternateName' => $profile->alternate_name,
                'jobTitle' => $profile->job_title,
                'description' => $profile->bio ? \Illuminate\Support\Str::limit(strip_tags($profile->bio), 300) : null,
                'url' => url('/'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $profile->location_city,
                    'addressCountry' => $profile->location_country,
                ],
                'sameAs' => array_values(array_filter([
                    $profile->instagram_url,
                    $profile->website_url,
                ])),
            ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
        </script>
    </x-slot:head>

    <section class="hero" data-hero aria-label="Introduction">
        <div class="hero-bg">
            <img
                src="{{ $heroImage }}"
                alt="{{ $profile->hero_image_alt ?? 'Quiet Jakarta sidewalk under a single warm streetlight' }}"
                fetchpriority="high"
            />
        </div>
        <div class="hero-overlay" aria-hidden="true"></div>

        <div class="hero-content container-wide">
            <div class="max-w-5xl" data-hero-stagger>
                <p class="font-label" style="color: var(--accent)">
                    <span>{{ $profile->location_city ?? 'Jakarta' }} · {{ $profile->location_country ?? 'Indonesia' }}</span>
                </p>
                <h1 class="text-display-hero mt-6">
                    @php
                        $nameParts = preg_split('/\s+/', trim($profile->name), 2);
                    @endphp
                    {{ $nameParts[0] ?? $profile->name }}<br />
                    {{ $nameParts[1] ?? '' }}<span class="accent-dot">.</span>
                </h1>
                <p class="mt-8 text-sm md:text-base" style="letter-spacing: 0.32em; text-transform: uppercase; color: var(--muted)">
                    {!! str_replace(' · ', ' &nbsp;·&nbsp; ', e($profile->specializations ?? 'Street · Human Interest · Landscape Photographer')) !!}
                </p>
                <p class="text-lead mt-6 max-w-xl">
                    Capturing authentic human moments, stories, and landscapes through visual storytelling.
                </p>
                <div class="mt-10 flex flex-wrap gap-4">
                    <a href="{{ route('portfolio.index') }}" class="btn btn-accent">
                        View Portfolio <span class="arrow">&rarr;</span>
                    </a>
                    <a href="{{ route('contact.show') }}" class="btn">
                        Contact Me
                    </a>
                </div>
            </div>
        </div>

        <div class="scroll-hint" aria-hidden="true">
            <span>Scroll</span>
            <span class="bar"></span>
        </div>
    </section>

    <section class="section-y" aria-label="About">
        <div class="container-wide grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16 items-center">
            <div class="md:col-span-5">
                <div class="framed aspect-[4/5]" data-reveal>
                    <img
                        src="{{ $aboutPortrait }}"
                        alt="{{ $profile->about_portrait_image_alt ?? 'Documentary portrait — weathered hands held quietly in the lap' }}"
                        loading="lazy"
                        decoding="async"
                    />
                </div>
            </div>
            <div class="md:col-span-7 md:pl-8">
                <p class="font-label" data-reveal>About</p>
                <h2 class="text-display-xl mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                    A documentary eye for outdoor and hospitality storytelling.
                </h2>
                @php
                    $bioParagraphs = $profile->bio
                        ? array_values(array_filter(array_map('trim', preg_split('/\r?\n\s*\r?\n/', $profile->bio))))
                        : [];
                @endphp
                @foreach (array_slice($bioParagraphs, 0, 2) as $i => $paragraph)
                    <p class="text-lead mt-{{ $i === 0 ? 8 : 4 }} max-w-xl" data-reveal data-reveal-delay="{{ 0.1 + $i * 0.05 }}">
                        {{ $paragraph }}
                    </p>
                @endforeach
                <div class="mt-10" data-reveal data-reveal-delay="0.2">
                    <a href="{{ route('about') }}" class="link-underline" style="letter-spacing: 0.2em; text-transform: uppercase; font-size: 0.78rem;">
                        Read the full story &rarr;
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="section-y hairline-top" aria-label="Selected work">
        <div class="container-wide">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
                <div>
                    <p class="font-label" data-reveal>Selected work</p>
                    <h2 class="text-display-xl mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                        Four disciplines,<br />one eye.
                    </h2>
                </div>
                <a
                    href="{{ route('portfolio.index') }}"
                    class="link-underline self-start md:self-end"
                    style="letter-spacing: 0.2em; text-transform: uppercase; font-size: 0.78rem;"
                    data-reveal
                    data-reveal-delay="0.1"
                >
                    Browse all series &rarr;
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 md:gap-8" data-reveal-group data-reveal-stagger="0.1">
                @foreach ($featuredSeries as $index => $series)
                    <x-series-tile :series="$series" :index="$index + 1" />
                @endforeach
            </div>
        </div>
    </section>

    @if ($profile->statement)
        <section class="section-y hairline-top" aria-label="Manifesto">
            <div class="container-narrow text-center">
                <p class="font-label mb-8" data-reveal>Statement</p>
                <p class="manifesto text-balance" data-reveal data-reveal-delay="0.05">
                    &ldquo;{{ $profile->statement }}&rdquo;
                </p>
            </div>
        </section>
    @endif

    <x-section-cta
        eyebrow="Open for assignments"
        heading="Available for assignments worldwide."
        lead="Cruise lines, hospitality brands, agencies, editorial &mdash; if your story needs an honest eye, let&rsquo;s talk."
        cta-label="Let's talk"
    />
</x-layouts.public>

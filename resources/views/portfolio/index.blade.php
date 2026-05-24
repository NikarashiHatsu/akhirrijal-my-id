@php
    $subhero = $profile->portfolio_subhero_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->portfolio_subhero_image_path)
        : \App\Support\NativeFallbacks::PORTFOLIO_SUBHERO;
@endphp

<x-layouts.public
    title="Portfolio — Four disciplines, one eye"
    description="Four disciplines, one eye. Browse street, human interest, landscape, and outdoor series by {{ $profile->location_city ?? 'Jakarta' }}-based photographer {{ $profile->name }}."
    :preload-image="$subhero"
    current="portfolio"
>
    <section class="subhero" aria-label="Portfolio">
        <div class="hero-bg">
            <img
                src="{{ $subhero }}"
                alt="{{ $profile->portfolio_subhero_image_alt ?? 'Volcanic ridge above a sea of low cloud at sunrise' }}"
                fetchpriority="high"
            />
        </div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-content container-wide">
            <div class="max-w-4xl" data-hero-stagger>
                <p class="font-label" style="color: var(--accent)"><span>Four disciplines, one eye</span></p>
                <h1 class="text-display-hero mt-6">Portfolio<span class="accent-dot">.</span></h1>
                <p class="text-lead mt-6 max-w-xl">
                    Selected series from the street, the home, the ridge, and the road.
                </p>
            </div>
        </div>
    </section>

    @foreach ($series as $index => $entry)
        @php
            $reversed = ($index % 2) === 1;
            $image = $entry->cover_image_path
                ? \Illuminate\Support\Facades\Storage::disk('public')->url($entry->cover_image_path)
                : \App\Support\NativeFallbacks::seriesCoverUrl($entry->slug);
            $aspect = $entry->aspect_ratio ?: '4/3';
            $seriesNumber = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
        @endphp

        <section
            class="section-y {{ $index === 0 ? '' : 'hairline-top' }}"
            aria-label="Series — {{ $entry->title }}"
        >
            <div class="container-wide grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16 items-center">
                <div class="md:col-span-{{ $reversed ? '5 md:order-2' : '7' }}" data-reveal>
                    <div class="framed" style="aspect-ratio: {{ $aspect }};">
                        <img
                            src="{{ $image }}"
                            alt="{{ $entry->cover_image_alt ?? $entry->title }}"
                            loading="lazy"
                            decoding="async"
                        />
                    </div>
                </div>
                <div class="md:col-span-{{ $reversed ? '7 md:order-1' : '5' }}">
                    <span class="pill" data-reveal><span class="dot"></span>Series {{ $seriesNumber }}</span>
                    <h2 class="text-display-xl mt-5 text-balance" data-reveal data-reveal-delay="0.05">{{ $entry->title }}.</h2>
                    <p class="text-lead mt-6 max-w-md" data-reveal data-reveal-delay="0.1">
                        {{ $entry->lead ?? $entry->short_description }}
                    </p>
                    <div class="mt-8" data-reveal data-reveal-delay="0.15">
                        <a href="{{ route('portfolio.show', $entry) }}" class="btn btn-accent">
                            Enter the series <span class="arrow">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    @endforeach

    <x-section-cta
        eyebrow="Commissions"
        heading="If a frame here moved you &mdash; let&rsquo;s make new ones."
        cta-label="Start a conversation"
    />
</x-layouts.public>

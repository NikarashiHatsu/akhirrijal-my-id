@php
    $subhero = $series->subhero_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($series->subhero_image_path)
        : \App\Support\NativeFallbacks::seriesSubheroUrl($series->slug);

    $seriesIndex = max(1, (int) $series->sort_order);
    $seriesNumber = str_pad((string) $seriesIndex, 2, '0', STR_PAD_LEFT);
@endphp

<x-layouts.public
    title="{{ $series->title }} — Series"
    :description="$series->lead ?? $series->short_description ?? ($series->title.' photography series by '.$profile->name.'.')"
    :preload-image="$subhero"
    current="portfolio"
>
    <section class="subhero" aria-label="{{ $series->title }} — series cover">
        <div class="hero-bg">
            <img
                src="{{ $subhero }}"
                alt="{{ $series->subhero_image_alt ?? $series->title }}"
                fetchpriority="high"
            />
        </div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-content container-wide">
            <div class="max-w-4xl" data-hero-stagger>
                <p class="font-label" style="color: var(--accent)">
                    <a href="{{ route('portfolio.index') }}" style="color: inherit; text-decoration: none">Portfolio</a>
                    <span style="margin-inline: 0.6rem">/</span>
                    <span>Series {{ $seriesNumber }}</span>
                </p>
                <h1 class="text-display-hero mt-6">{{ $series->title }}<span class="accent-dot">.</span></h1>
                @if ($series->lead || $series->short_description)
                    <p class="text-lead mt-6 max-w-xl">
                        {{ $series->lead ?? $series->short_description }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <section class="section-y-sm" aria-label="{{ $series->title }} gallery">
        <div class="container-wide">
            @if ($photos->isEmpty())
                <p class="text-lead" style="color: var(--muted)" data-reveal>
                    Series in progress &mdash; new frames coming soon.
                </p>
            @else
                <div
                    class="masonry columns-1 sm:columns-2 lg:columns-3"
                    data-gallery
                    data-gallery-title="{{ $series->title }}"
                >
                    @foreach ($photos as $index => $photo)
                        @php
                            $counter = str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT);
                            $url = $photo->url();
                        @endphp
                        @if ($url)
                            <a
                                class="gallery-item"
                                href="{{ $url }}"
                                data-pswp-width="{{ $photo->width ?? 1600 }}"
                                data-pswp-height="{{ $photo->height ?? 1067 }}"
                                data-pswp-title="{{ $photo->title }}"
                                data-pswp-story="{{ $photo->story }}"
                                data-pswp-location="{{ $photo->location }}"
                                data-pswp-date="{{ $photo->date_label ?? optional($photo->taken_at)->format('F Y') }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                aria-label="Open photo {{ $index + 1 }} of {{ $photos->count() }}: {{ $photo->title }}"
                            >
                                <img
                                    src="{{ $url }}"
                                    alt="{{ $photo->alt ?? $photo->title }}"
                                    loading="lazy"
                                    decoding="async"
                                />
                                <figcaption class="caption">
                                    <span class="caption-eyebrow">{{ $series->title }} &middot; {{ $counter }}</span>
                                    <span class="caption-title">{{ $photo->title }}</span>
                                </figcaption>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="container-wide" aria-label="Series navigation">
        <div class="cat-nav">
            <a href="{{ route('portfolio.show', $previous) }}">
                <span class="label">&larr; Previous series</span>
                <span class="name">{{ $previous->title }}</span>
            </a>
            <a href="{{ route('portfolio.show', $next) }}" style="text-align: right; align-items: flex-end">
                <span class="label">Next series &rarr;</span>
                <span class="name">{{ $next->title }}</span>
            </a>
        </div>
    </section>

    <x-section-cta
        eyebrow="Commissions"
        heading="Looking for {{ strtolower($series->title) }} imagery for your brand?"
        cta-label="Start a brief"
        aria-label="Commission CTA"
    />
</x-layouts.public>

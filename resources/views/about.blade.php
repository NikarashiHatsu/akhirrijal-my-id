@php
    $subhero = $profile->about_subhero_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->about_subhero_image_path)
        : \App\Support\NativeFallbacks::ABOUT_SUBHERO;

    $bioParagraphs = $profile->bio
        ? array_values(array_filter(array_map('trim', preg_split('/\r?\n\s*\r?\n/', $profile->bio))))
        : [];
@endphp

<x-layouts.public
    title="About — Behind the lens"
    description="Behind the lens with {{ $profile->name }} — a {{ $profile->location_city ?? 'Jakarta' }}-based freelance photographer focused on authentic moments, outdoor storytelling, and international hospitality photography."
    :preload-image="$subhero"
    current="about"
>
    <section class="subhero" aria-label="About — Behind the lens">
        <div class="hero-bg">
            <img
                src="{{ $subhero }}"
                alt="{{ $profile->about_subhero_image_alt ?? 'Photographer pausing at the end of a long shooting day' }}"
                fetchpriority="high"
            />
        </div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-content container-wide">
            <div class="max-w-4xl" data-hero-stagger>
                <p class="font-label" style="color: var(--accent)"><span>About · Behind the lens</span></p>
                <h1 class="text-display-hero mt-6">Behind the lens<span class="accent-dot">.</span></h1>
                <p class="text-lead mt-6 max-w-xl">
                    The story, the gear, and the way of working &mdash; in plain words.
                </p>
            </div>
        </div>
    </section>

    <section class="section-y" aria-label="Biography">
        <div class="container-wide grid grid-cols-1 md:grid-cols-12 gap-10 md:gap-16">
            <div class="md:col-span-5">
                <p class="font-label" data-reveal>Who</p>
                <h2 class="text-display-xl mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                    Freelance photographer from {{ $profile->location_city ?? 'Jakarta' }} &mdash; <span style="color: var(--accent)">drawn to honest, outdoor moments.</span>
                </h2>
            </div>
            <div class="md:col-span-7 md:pl-8">
                @forelse ($bioParagraphs as $i => $paragraph)
                    <p class="text-lead {{ $i === 0 ? '' : 'mt-6' }}" data-reveal data-reveal-delay="{{ 0.05 + $i * 0.05 }}">
                        {{ $paragraph }}
                    </p>
                @empty
                    <p class="text-lead" data-reveal>
                        Biography coming soon.
                    </p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-y hairline-top" aria-label="Experience">
        <div class="container-wide">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
                <div>
                    <p class="font-label" data-reveal>Experience</p>
                    <h2 class="text-display-xl mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                        How I work.
                    </h2>
                </div>
                <p class="text-sm max-w-sm" style="color: var(--muted)" data-reveal data-reveal-delay="0.1">
                    A practical look at the disciplines I draw from on every assignment.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6" data-reveal-group data-reveal-stagger="0.08">
                @foreach ($experiences as $experience)
                    <x-card
                        :number-label="$experience->number_label"
                        :title="$experience->title"
                        :description="$experience->description"
                    />
                @endforeach
            </div>
        </div>
    </section>

    <section class="section-y hairline-top" aria-label="Equipment">
        <div class="container-wide">
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-14">
                <div>
                    <p class="font-label" data-reveal>Equipment</p>
                    <h2 class="text-display-xl mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                        The kit, kept simple.
                    </h2>
                </div>
                <p class="text-sm max-w-sm" style="color: var(--muted)" data-reveal data-reveal-delay="0.1">
                    A small, reliable set that I know intimately &mdash; chosen for character, not spec sheets.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" data-reveal-group data-reveal-stagger="0.07">
                @foreach ($equipment as $item)
                    <x-equipment-card :equipment="$item" />
                @endforeach
            </div>
        </div>
    </section>

    <x-section-cta
        eyebrow="The work"
        heading="See the frames, not the words."
        lead="Four series &mdash; street, human interest, landscape, and outdoor &mdash; that say more about the practice than a paragraph ever could."
        cta-label="Open portfolio"
        :cta-href="route('portfolio.index')"
        aria-label="See the work"
    />
</x-layouts.public>

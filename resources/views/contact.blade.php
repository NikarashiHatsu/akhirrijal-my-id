@php
    $subhero = $profile->contact_subhero_image_path
        ? \Illuminate\Support\Facades\Storage::disk('public')->url($profile->contact_subhero_image_path)
        : \App\Support\NativeFallbacks::CONTACT_SUBHERO;

    $detailLinks = [];
    if ($profile->email) {
        $detailLinks[] = ['label' => 'Email', 'value' => $profile->email, 'href' => 'mailto:'.$profile->email, 'external' => false];
    }
    if ($profile->whatsapp_display && $profile->whatsapp_e164) {
        $detailLinks[] = ['label' => 'WhatsApp', 'value' => $profile->whatsapp_display, 'href' => 'https://wa.me/'.$profile->whatsapp_e164, 'external' => true];
    }
    if ($profile->instagram_handle && $profile->instagram_url) {
        $detailLinks[] = ['label' => 'Instagram', 'value' => $profile->instagram_handle, 'href' => $profile->instagram_url, 'external' => true];
    }
    if ($profile->website_url) {
        $detailLinks[] = ['label' => 'Website', 'value' => parse_url($profile->website_url, PHP_URL_HOST) ?? $profile->website_url, 'href' => $profile->website_url, 'external' => true];
    }
@endphp

<x-layouts.public
    title="Contact — Let's create something honest"
    description="Get in touch with {{ $profile->name }} — {{ $profile->location_city ?? 'Jakarta' }}-based documentary &amp; outdoor photographer available worldwide for hospitality, cruise, and editorial assignments."
    :preload-image="$subhero"
    current="contact"
>
    <section class="subhero" aria-label="Contact">
        <div class="hero-bg">
            <img
                src="{{ $subhero }}"
                alt="{{ $profile->contact_subhero_image_alt ?? 'Two travelers on a coastal road at golden hour' }}"
                fetchpriority="high"
            />
        </div>
        <div class="hero-overlay" aria-hidden="true"></div>
        <div class="hero-content container-wide">
            <div class="max-w-4xl" data-hero-stagger>
                <p class="font-label" style="color: var(--accent)"><span>Contact · {{ $profile->availability_status ?? 'Available worldwide' }}</span></p>
                <h1 class="text-display-hero mt-6">Let&rsquo;s create something honest<span class="accent-dot">.</span></h1>
                <p class="text-lead mt-6 max-w-xl">
                    Cruise, hospitality, editorial, brand &mdash; tell me about your story and the place it lives.
                </p>
            </div>
        </div>
    </section>

    <section class="section-y" aria-label="Contact details and form">
        <div class="container-wide grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-16">
            <aside class="md:col-span-5" aria-label="Contact details">
                <p class="font-label" data-reveal>Direct</p>
                <h2 class="text-display-lg mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                    The fastest way to reach me.
                </h2>
                <p class="text-lead mt-6 max-w-md" data-reveal data-reveal-delay="0.1">
                    I read every message personally and reply within two working days. For urgent briefs, WhatsApp is best.
                </p>

                <ul class="mt-12 flex flex-col" style="border-top: 1px solid var(--hairline)">
                    @foreach ($detailLinks as $i => $link)
                        <li class="py-5" style="border-bottom: 1px solid var(--hairline)" data-reveal data-reveal-delay="{{ $i * 0.05 }}">
                            <span class="font-label block mb-2">{{ $link['label'] }}</span>
                            <a
                                class="link-underline text-lg"
                                style="font-family: var(--font-display); font-weight: 300"
                                href="{{ $link['href'] }}"
                                @if ($link['external'])
                                    target="_blank"
                                    rel="noopener noreferrer"
                                @endif
                                data-no-transition
                            >{{ $link['value'] }}</a>
                        </li>
                    @endforeach
                    <li class="py-5" data-reveal data-reveal-delay="{{ count($detailLinks) * 0.05 }}">
                        <span class="font-label block mb-2">Based in</span>
                        <span class="text-lg" style="font-family: var(--font-display); font-weight: 300">
                            {{ $profile->location_city ?? 'Jakarta' }}, {{ $profile->location_country ?? 'Indonesia' }} &middot;
                            <span style="color: var(--accent)">{{ $profile->availability_status ?? 'Available worldwide' }}</span>
                        </span>
                    </li>
                </ul>
            </aside>

            <div class="md:col-span-7 md:pl-8">
                <p class="font-label" data-reveal>Project form</p>
                <h2 class="text-display-lg mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                    Tell me about the project.
                </h2>
                <p class="text-lead mt-6 max-w-xl" data-reveal data-reveal-delay="0.1">
                    A few words about the story, dates, and location is plenty. I&rsquo;ll come back with thoughts, references, and a rough proposal.
                </p>

                @if (session('status') === 'sent')
                    <div class="alert-success mt-10" role="status" data-reveal>
                        Got it &mdash; I'll reply within two working days.
                    </div>
                @endif

                <form
                    class="mt-12 grid grid-cols-1 sm:grid-cols-2 gap-8"
                    method="POST"
                    action="{{ route('contact.store') }}"
                    aria-label="Contact form"
                    data-reveal
                    data-reveal-delay="0.15"
                >
                    @csrf

                    <div class="field-honeypot" aria-hidden="true">
                        <label for="cf-company">Company (leave empty)</label>
                        <input id="cf-company" name="company" type="text" tabindex="-1" autocomplete="off" />
                    </div>

                    <div class="field">
                        <label for="cf-name">Your name</label>
                        <input
                            id="cf-name"
                            name="name"
                            type="text"
                            autocomplete="name"
                            required
                            placeholder="Maria Santos"
                            value="{{ old('name') }}"
                        />
                        @error('name') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field">
                        <label for="cf-email">Email</label>
                        <input
                            id="cf-email"
                            name="email"
                            type="email"
                            autocomplete="email"
                            required
                            placeholder="you@brand.com"
                            value="{{ old('email') }}"
                        />
                        @error('email') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field sm:col-span-2">
                        <label for="cf-subject">Subject</label>
                        <input
                            id="cf-subject"
                            name="subject"
                            type="text"
                            required
                            placeholder="Mediterranean cruise · onboard photography"
                            value="{{ old('subject') }}"
                        />
                        @error('subject') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="field sm:col-span-2">
                        <label for="cf-message">Tell me about the project</label>
                        <textarea
                            id="cf-message"
                            name="message"
                            rows="6"
                            required
                            placeholder="A few words about the story, dates, and location…"
                        >{{ old('message') }}</textarea>
                        @error('message') <span class="field-error">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2 flex flex-col sm:flex-row sm:items-center gap-6 mt-2">
                        <button type="submit" class="btn btn-accent">
                            Send message <span class="arrow">&rarr;</span>
                        </button>
                        @if ($profile->email)
                            <p class="text-xs" style="color: var(--muted-2); letter-spacing: 0.18em; text-transform: uppercase;">
                                I&rsquo;ll reply by email &middot; or write directly to {{ $profile->email }}
                            </p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="section-y-sm hairline-top hairline-bottom" aria-label="Location">
        <div class="container-wide flex flex-col md:flex-row md:items-end md:justify-between gap-6">
            <div>
                <p class="font-label" data-reveal>Coordinates</p>
                <h3 class="text-display-lg mt-3" data-reveal data-reveal-delay="0.05">
                    Based in {{ $profile->location_city ?? 'Jakarta' }} &mdash; <span style="color: var(--accent)">on assignment worldwide.</span>
                </h3>
            </div>
            <p class="text-sm max-w-md" style="color: var(--muted)" data-reveal data-reveal-delay="0.1">
                Currently open to international hospitality and cruise contracts.<br />
                Passport and equipment, ready.
            </p>
        </div>
    </section>
</x-layouts.public>

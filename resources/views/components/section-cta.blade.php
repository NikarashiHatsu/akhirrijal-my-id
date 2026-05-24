@props([
    'eyebrow' => 'Open for assignments',
    'heading',
    'lead' => null,
    'ctaLabel' => "Let's talk",
    'ctaHref' => null,
    'ariaLabel' => 'Contact CTA',
])

@php
    $href = $ctaHref ?? route('contact.show');
@endphp

<section class="section-y hairline-top" aria-label="{{ $ariaLabel }}">
    <div class="container-wide">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 items-end">
            <div class="md:col-span-8">
                <p class="font-label" style="color: var(--accent)" data-reveal>{{ $eyebrow }}</p>
                <h2 class="text-display-xl mt-4 text-balance" data-reveal data-reveal-delay="0.05">
                    {!! $heading !!}
                </h2>
                @if ($lead)
                    <p class="text-lead mt-6 max-w-xl" data-reveal data-reveal-delay="0.1">
                        {!! $lead !!}
                    </p>
                @endif
            </div>
            <div class="md:col-span-4 md:text-right" data-reveal data-reveal-delay="0.15">
                <a href="{{ $href }}" class="btn btn-accent">
                    {{ $ctaLabel }} <span class="arrow">&rarr;</span>
                </a>
            </div>
        </div>
    </div>
</section>

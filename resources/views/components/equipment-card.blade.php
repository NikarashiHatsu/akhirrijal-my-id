@props([
    'equipment',
])

<article class="card flex flex-col" data-reveal-child>
    <div
        class="aspect-[4/3] mb-6 flex flex-col justify-between"
        style="border: 1px solid var(--hairline); padding: 1.25rem; background: linear-gradient(180deg, rgba(28,26,24,0.6), rgba(10,10,10,0.6));"
    >
        @if ($equipment->badge_label)
            <span class="font-label" style="color: var(--accent)">{{ $equipment->badge_label }}</span>
        @endif
        @if ($equipment->badge_value)
            <span
                class="font-display block"
                style="font-family: var(--font-display); font-weight: 200; font-size: clamp(2rem, 3.6vw, 3rem); letter-spacing: -0.02em; line-height: 1;"
            >{{ $equipment->badge_value }}</span>
        @endif
    </div>

    @if ($equipment->category_label)
        <span class="font-label" style="color: var(--accent)">{{ $equipment->category_label }}</span>
    @endif
    <h3 class="text-display-md mt-2">{{ $equipment->name }}</h3>
    @if ($equipment->description)
        <p class="mt-3 text-sm" style="color: var(--muted)">{{ $equipment->description }}</p>
    @endif
</article>

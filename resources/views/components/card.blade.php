@props([
    'numberLabel' => null,
    'title' => '',
    'description' => null,
])

<article class="card" data-reveal-child>
    @if ($numberLabel)
        <span class="num">{{ $numberLabel }}</span>
    @endif
    <h3 class="text-display-md mt-3">{{ $title }}</h3>
    @if ($description)
        <p class="mt-4" style="color: var(--muted)">{{ $description }}</p>
    @endif
</article>

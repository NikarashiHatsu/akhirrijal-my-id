<?php

namespace App\Support;

/**
 * Static Unsplash fallback URLs lifted verbatim from the original native/ site.
 *
 * The photographer can replace these by uploading hero, portrait, and series
 * cover images through the Filament admin panel; until then these defaults
 * keep every page visually complete.
 */
class NativeFallbacks
{
    public const HOME_HERO = 'https://images.unsplash.com/photo-1659608927883-dc6d6f40ac1a?auto=format&fit=crop&w=2400&q=80';

    public const ABOUT_PORTRAIT = 'https://images.unsplash.com/photo-1488161628813-04466f872be2?auto=format&fit=crop&w=1200&q=80';

    public const ABOUT_SUBHERO = 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=1920&q=80';

    public const PORTFOLIO_SUBHERO = 'https://images.unsplash.com/photo-1587651687979-77cf05d1b841?auto=format&fit=crop&w=1920&q=80';

    public const CONTACT_SUBHERO = 'https://images.unsplash.com/photo-1473773508845-188df298d2d1?auto=format&fit=crop&w=1920&q=80';

    /**
     * Series cover photographs keyed by slug.
     *
     * @var array<string, string>
     */
    public const SERIES_COVERS = [
        'street' => 'https://images.unsplash.com/photo-1659608927883-dc6d6f40ac1a?auto=format&fit=crop&w=1600&q=80',
        'human-interest' => 'https://images.unsplash.com/photo-1518725522904-4b3939358342?auto=format&fit=crop&w=1600&q=80',
        'landscape' => 'https://images.unsplash.com/photo-1587651687979-77cf05d1b841?auto=format&fit=crop&w=1600&q=80',
        'outdoor' => 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=1600&q=80',
    ];

    /**
     * Larger sub-hero crops for series detail pages.
     *
     * @var array<string, string>
     */
    public const SERIES_SUBHEROS = [
        'street' => 'https://images.unsplash.com/photo-1659608927883-dc6d6f40ac1a?auto=format&fit=crop&w=1920&q=80',
        'human-interest' => 'https://images.unsplash.com/photo-1518725522904-4b3939358342?auto=format&fit=crop&w=1920&q=80',
        'landscape' => 'https://images.unsplash.com/photo-1587651687979-77cf05d1b841?auto=format&fit=crop&w=1920&q=80',
        'outdoor' => 'https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&w=1920&q=80',
    ];

    public static function seriesCoverUrl(string $slug): string
    {
        return self::SERIES_COVERS[$slug] ?? self::PORTFOLIO_SUBHERO;
    }

    public static function seriesSubheroUrl(string $slug): string
    {
        return self::SERIES_SUBHEROS[$slug] ?? self::PORTFOLIO_SUBHERO;
    }
}

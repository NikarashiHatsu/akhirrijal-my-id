<?php

namespace Database\Seeders;

use App\Models\Series;
use Illuminate\Database\Seeder;

class SeriesSeeder extends Seeder
{
    public function run(): void
    {
        $series = [
            [
                'slug' => 'street',
                'title' => 'Street',
                'lead' => 'Honest, unscripted scenes from Indonesian streets — where light, noise, and humanity collide.',
                'short_description' => 'Honest, unscripted scenes from Indonesian streets — where light, noise, and humanity collide.',
                'sort_order' => 1,
                'aspect_ratio' => '4/3',
                'cover_image_alt' => 'Street — quiet Jakarta sidewalk under warm light',
                'subhero_image_alt' => 'Quiet Jakarta sidewalk under a single warm streetlight',
            ],
            [
                'slug' => 'human-interest',
                'title' => 'Human Interest',
                'lead' => 'The quiet portraits, the small gestures, the dignity of strangers — the work of remembering people as people.',
                'short_description' => 'The quiet portraits, the small gestures, the dignity of strangers — the work of remembering people as people.',
                'sort_order' => 2,
                'aspect_ratio' => '3/4',
                'cover_image_alt' => 'Human interest — quiet portrait in traditional dress',
                'subhero_image_alt' => 'Quiet portrait in traditional dress',
            ],
            [
                'slug' => 'landscape',
                'title' => 'Landscape',
                'lead' => 'Volcanoes, ridges, fog, and coastline — the Indonesian land at the hour when it speaks most clearly.',
                'short_description' => 'Volcanoes, ridges, fog, and coastline — the Indonesian land at the hour when it speaks most clearly.',
                'sort_order' => 3,
                'aspect_ratio' => '16/10',
                'cover_image_alt' => 'Landscape — volcanic ridge above a sea of low cloud',
                'subhero_image_alt' => 'Volcanic ridge above a sea of low cloud at sunrise',
            ],
            [
                'slug' => 'outdoor',
                'title' => 'Outdoor',
                'lead' => 'Travel, expedition, and adventure — life lived under open sky, captured between the planning and the rest.',
                'short_description' => 'Travel, expedition, and adventure — life lived under open sky, captured between the planning and the rest.',
                'sort_order' => 4,
                'aspect_ratio' => '4/5',
                'cover_image_alt' => 'Outdoor — trail running through an alpine meadow',
                'subhero_image_alt' => 'Trail running through an alpine meadow at golden hour',
            ],
        ];

        foreach ($series as $row) {
            Series::query()->updateOrCreate(['slug' => $row['slug']], $row);
        }
    }
}

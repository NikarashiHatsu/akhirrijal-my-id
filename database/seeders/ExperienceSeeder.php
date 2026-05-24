<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $cards = [
            [
                'sort_order' => 1,
                'number_label' => '01',
                'title' => 'Freelance Photography',
                'description' => 'Independent practice across Jakarta and Indonesia — editorial, lifestyle, and personal commissions, delivered end-to-end from brief to final files.',
            ],
            [
                'sort_order' => 2,
                'number_label' => '02',
                'title' => 'Tourism & Hospitality Exposure',
                'description' => 'Drawn to international travel, hotels, resorts, and cruise environments. Trained to be calm and unobtrusive around guests and crew.',
            ],
            [
                'sort_order' => 3,
                'number_label' => '03',
                'title' => 'Adobe Photoshop Editing',
                'description' => 'Refined color grading, tonal sculpting, and retouching — consistent visual storytelling across series, locations, and assignments.',
            ],
            [
                'sort_order' => 4,
                'number_label' => '04',
                'title' => 'Canon Camera Experience',
                'description' => 'Long-form experience on Canon EOS bodies with fast prime lenses — built for low-light, character-led portraiture and reportage.',
            ],
        ];

        foreach ($cards as $card) {
            Experience::query()->updateOrCreate(
                ['number_label' => $card['number_label']],
                $card,
            );
        }
    }
}

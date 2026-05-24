<?php

namespace Database\Seeders;

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'sort_order' => 1,
                'badge_label' => 'DSLR · APS-C',
                'badge_value' => '60D',
                'category_label' => 'Body',
                'name' => 'Canon EOS 60D',
                'description' => 'The workhorse. Reliable APS-C image quality with controls that fall to hand without thinking.',
            ],
            [
                'sort_order' => 2,
                'badge_label' => 'Prime · f/1.8',
                'badge_value' => '50mm',
                'category_label' => 'Prime',
                'name' => 'Canon 50mm',
                'description' => 'The natural-vision focal length — for street, candid portraiture, and quiet reportage.',
            ],
            [
                'sort_order' => 3,
                'badge_label' => 'Prime · f/1.8',
                'badge_value' => '85mm',
                'category_label' => 'Prime',
                'name' => 'Canon 85mm',
                'description' => 'Short telephoto for compressed portraits, intimate moments, and a soft separation from background.',
            ],
            [
                'sort_order' => 4,
                'badge_label' => 'Color · Retouch',
                'badge_value' => 'Ps',
                'category_label' => 'Finish',
                'name' => 'Adobe Photoshop',
                'description' => 'Tonal sculpting, color grading, and finishing — quietly, so the moment stays the loudest thing.',
            ],
        ];

        foreach ($items as $item) {
            Equipment::query()->updateOrCreate(
                ['name' => $item['name']],
                $item,
            );
        }
    }
}

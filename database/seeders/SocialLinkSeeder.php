<?php

namespace Database\Seeders;

use App\Models\SocialLink;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $links = [
            [
                'platform' => 'email',
                'label' => 'qothrul112358@gmail.com',
                'url' => 'mailto:qothrul112358@gmail.com',
                'sort_order' => 1,
            ],
            [
                'platform' => 'whatsapp',
                'label' => 'WhatsApp · +62 838-2448-2936',
                'url' => 'https://wa.me/6283824482936',
                'sort_order' => 2,
            ],
            [
                'platform' => 'instagram',
                'label' => 'Instagram · @senandung_hujan',
                'url' => 'https://instagram.com/senandung_hujan',
                'sort_order' => 3,
            ],
            [
                'platform' => 'website',
                'label' => 'akhirrijal',
                'url' => 'https://akhirrijal.my.id',
                'sort_order' => 4,
            ],
        ];

        foreach ($links as $link) {
            SocialLink::query()->updateOrCreate(
                ['platform' => $link['platform']],
                $link,
            );
        }
    }
}

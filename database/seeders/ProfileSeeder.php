<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->updateOrCreate(['id' => 1], [
            'name' => 'Qothrul Aziz Akhirrijal',
            'alternate_name' => 'Akhirrijal',
            'monogram' => 'Akhirrijal',
            'job_title' => 'Photographer',
            'tagline' => 'Documentary & Outdoor Photographer',
            'specializations' => 'Street · Human Interest · Landscape Photographer',
            'bio' => <<<'BIO'
I'm Qothrul Aziz Akhirrijal — a freelance photographer based in Jakarta, Indonesia. My work is about authentic moments and the wide breath of the outdoor world: street markets at dawn, the stillness of mountain ridges, and the unscripted in-between of travel. I look for emotion, character, and atmosphere, and I try not to interrupt them.

I'm particularly interested in international hospitality and cruise photography. I bring a documentary sensibility to commercial environments — the kind of frame that makes strangers feel seen and places feel felt. I shoot primarily on Canon with fast prime lenses, and finish my work in Adobe Photoshop, refining color and tone while keeping the soul of the moment intact.

Whether the brief is a private assignment, a brand story, a guest experience aboard ship, or an editorial feature on a coastline I've never seen — I bring patience, calm presence, and an eye that has been trained on documenting emotion, culture, and environment.
BIO,
            'statement' => 'I photograph the gap between people and place — the small honesty that survives between the planning and the rest.',
            'location_city' => 'Jakarta',
            'location_country' => 'Indonesia',
            'availability_status' => 'Available worldwide',
            'email' => 'qothrul112358@gmail.com',
            'whatsapp_e164' => '6283824482936',
            'whatsapp_display' => '+62 838-2448-2936',
            'instagram_handle' => '@senandung_hujan',
            'instagram_url' => 'https://instagram.com/senandung_hujan',
            'website_url' => 'https://akhirrijal.my.id',
            'hero_image_alt' => 'Quiet Jakarta sidewalk under a single warm streetlight',
            'about_portrait_image_alt' => 'Documentary portrait — weathered hands held quietly in the lap',
            'about_subhero_image_alt' => 'Photographer pausing at the end of a long shooting day',
            'portfolio_subhero_image_alt' => 'Volcanic ridge above a sea of low cloud at sunrise',
            'contact_subhero_image_alt' => 'Two travelers on a coastal road at golden hour',
            'crafted_in_label' => 'Crafted in Jakarta · Indonesia',
        ]);
    }
}

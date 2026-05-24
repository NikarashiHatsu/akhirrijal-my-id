<?php

namespace App\View\Composers;

use App\Models\Profile;
use App\Models\SocialLink;
use Illuminate\View\View;

class PublicLayoutComposer
{
    public function compose(View $view): void
    {
        $view->with([
            'profile' => Profile::query()->orderBy('id')->first() ?? new Profile([
                'name' => config('app.name', 'Akhirrijal'),
                'tagline' => 'Documentary & Outdoor Photographer',
                'availability_status' => 'Available worldwide',
                'crafted_in_label' => 'Crafted in Jakarta · Indonesia',
            ]),
            'socialLinks' => SocialLink::query()->ordered()->get(),
        ]);
    }
}

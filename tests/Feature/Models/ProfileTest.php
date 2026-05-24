<?php

use App\Models\Profile;

it('persists every documented column on the profile singleton', function () {
    $profile = Profile::create([
        'name' => 'Qothrul Aziz Akhirrijal',
        'alternate_name' => 'Akhirrijal',
        'monogram' => 'Akhirrijal',
        'job_title' => 'Photographer',
        'tagline' => 'Documentary & Outdoor Photographer',
        'specializations' => 'Street · Human Interest · Landscape Photographer',
        'bio' => "First paragraph.\n\nSecond paragraph.",
        'statement' => 'I photograph the gap between people and place.',
        'location_city' => 'Jakarta',
        'location_country' => 'Indonesia',
        'availability_status' => 'Available worldwide',
        'email' => 'qothrul112358@gmail.com',
        'whatsapp_e164' => '6283824482936',
        'whatsapp_display' => '+62 838-2448-2936',
        'instagram_handle' => '@senandung_hujan',
        'instagram_url' => 'https://instagram.com/senandung_hujan',
        'website_url' => 'https://akhirrijal.my.id',
        'hero_image_path' => 'profile/hero.jpg',
        'hero_image_alt' => 'Quiet Jakarta sidewalk under warm light',
        'about_portrait_image_path' => 'profile/about-portrait.jpg',
        'about_portrait_image_alt' => 'Documentary portrait',
        'about_subhero_image_path' => 'profile/about-subhero.jpg',
        'about_subhero_image_alt' => 'Photographer pausing',
        'portfolio_subhero_image_path' => 'profile/portfolio-subhero.jpg',
        'portfolio_subhero_image_alt' => 'Volcanic ridge',
        'contact_subhero_image_path' => 'profile/contact-subhero.jpg',
        'contact_subhero_image_alt' => 'Two travelers on a coastal road',
        'crafted_in_label' => 'Crafted in Jakarta · Indonesia',
    ]);

    expect($profile->refresh())
        ->name->toBe('Qothrul Aziz Akhirrijal')
        ->alternate_name->toBe('Akhirrijal')
        ->job_title->toBe('Photographer')
        ->whatsapp_e164->toBe('6283824482936')
        ->instagram_handle->toBe('@senandung_hujan')
        ->hero_image_path->toBe('profile/hero.jpg')
        ->contact_subhero_image_alt->toBe('Two travelers on a coastal road');
});

it('exposes a singleton accessor that returns the first row', function () {
    $first = Profile::factory()->create();
    Profile::factory()->create();

    expect(Profile::singleton()->is($first))->toBeTrue();
});

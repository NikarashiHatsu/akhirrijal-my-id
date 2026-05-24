<?php

use App\Models\SocialLink;

it('persists the documented columns on a social link', function () {
    $link = SocialLink::create([
        'platform' => 'instagram',
        'label' => 'Instagram · @senandung_hujan',
        'url' => 'https://instagram.com/senandung_hujan',
        'sort_order' => 3,
    ]);

    expect($link->refresh())
        ->platform->toBe('instagram')
        ->label->toBe('Instagram · @senandung_hujan')
        ->url->toBe('https://instagram.com/senandung_hujan')
        ->sort_order->toBe(3);
});

it('orders links by sort_order via the ordered scope', function () {
    SocialLink::factory()->create(['platform' => 'website', 'sort_order' => 4]);
    SocialLink::factory()->create(['platform' => 'email', 'sort_order' => 1]);
    SocialLink::factory()->create(['platform' => 'whatsapp', 'sort_order' => 2]);

    expect(SocialLink::ordered()->pluck('platform')->all())
        ->toBe(['email', 'whatsapp', 'website']);
});

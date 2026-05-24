<?php

use App\Models\Equipment;

it('persists the documented columns on an equipment card', function () {
    $equipment = Equipment::create([
        'sort_order' => 1,
        'badge_label' => 'DSLR · APS-C',
        'badge_value' => '60D',
        'category_label' => 'Body',
        'name' => 'Canon EOS 60D',
        'description' => 'The workhorse. Reliable APS-C image quality with controls that fall to hand without thinking.',
    ]);

    expect($equipment->refresh())
        ->sort_order->toBe(1)
        ->badge_label->toBe('DSLR · APS-C')
        ->badge_value->toBe('60D')
        ->category_label->toBe('Body')
        ->name->toBe('Canon EOS 60D')
        ->description->toContain('workhorse');
});

it('orders equipment cards by sort_order via the ordered scope', function () {
    Equipment::factory()->create(['sort_order' => 4, 'name' => 'Adobe Photoshop']);
    Equipment::factory()->create(['sort_order' => 1, 'name' => 'Canon EOS 60D']);
    Equipment::factory()->create(['sort_order' => 2, 'name' => 'Canon 50mm']);

    expect(Equipment::ordered()->pluck('name')->all())
        ->toBe(['Canon EOS 60D', 'Canon 50mm', 'Adobe Photoshop']);
});

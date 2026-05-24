<?php

use App\Models\Experience;

it('persists the documented columns on an experience card', function () {
    $experience = Experience::create([
        'sort_order' => 1,
        'number_label' => '01',
        'title' => 'Freelance Photography',
        'description' => 'Independent practice across Jakarta and Indonesia — editorial, lifestyle, and personal commissions.',
    ]);

    expect($experience->refresh())
        ->sort_order->toBe(1)
        ->number_label->toBe('01')
        ->title->toBe('Freelance Photography')
        ->description->toContain('Independent practice');
});

it('orders experience cards by sort_order via the ordered scope', function () {
    Experience::factory()->create(['sort_order' => 3, 'number_label' => '03']);
    Experience::factory()->create(['sort_order' => 1, 'number_label' => '01']);
    Experience::factory()->create(['sort_order' => 2, 'number_label' => '02']);

    expect(Experience::ordered()->pluck('number_label')->all())
        ->toBe(['01', '02', '03']);
});

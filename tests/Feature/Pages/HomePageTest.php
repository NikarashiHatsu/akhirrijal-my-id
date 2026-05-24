<?php

use App\Models\Profile;
use App\Models\Series;
use Database\Seeders\SeriesSeeder;

beforeEach(function () {
    Profile::factory()->create();
    (new SeriesSeeder)->run();
});

it('renders the home page with hero, manifesto, and four series tiles', function () {
    $response = $this->get(route('home'));

    $response->assertOk();

    foreach (Series::query()->ordered()->pluck('title') as $title) {
        $response->assertSeeText($title);
    }

    $response->assertSeeText('Available worldwide');
    $response->assertSeeText('Selected work');
});

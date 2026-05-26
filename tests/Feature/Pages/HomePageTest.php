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

it('renders editable home copy from the profile', function () {
    Profile::query()->delete();

    Profile::factory()->create([
        'hero_lead' => 'Custom hero lead copy for the home page.',
        'home_about_heading' => 'Custom about heading on the home page.',
        'home_selected_work_heading' => "First line of work heading.\nSecond line of work heading.",
    ]);

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSeeText('Custom hero lead copy for the home page.');
    $response->assertSeeText('Custom about heading on the home page.');
    $response->assertSeeText('First line of work heading.');
    $response->assertSeeText('Second line of work heading.');
});

it('renders series tiles with their configured aspect ratios', function () {
    $series = Series::query()->ordered()->firstOrFail();

    $response = $this->get(route('home'));

    $response->assertOk();
    $response->assertSee('aspect-ratio: '.$series->aspect_ratio.';', false);
});

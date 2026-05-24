<?php

use App\Models\Profile;
use App\Models\Series;
use Database\Seeders\SeriesSeeder;

beforeEach(function () {
    Profile::factory()->create();
    (new SeriesSeeder)->run();
});

it('renders the portfolio hub with all four series and their links', function () {
    $response = $this->get(route('portfolio.index'));

    $response->assertOk();
    $response->assertSeeText('Four disciplines, one eye');

    Series::query()->ordered()->each(function (Series $series) use ($response) {
        $response->assertSeeText($series->title);
        $response->assertSee(route('portfolio.show', $series), false);
    });
});

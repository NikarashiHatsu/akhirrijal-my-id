<?php

use App\Models\Profile;
use App\Models\Series;
use Database\Seeders\SeriesSeeder;

beforeEach(function () {
    Profile::factory()->create();
    (new SeriesSeeder)->run();
});

it('includes site icon meta and link tags on every public page', function () {
    $street = Series::query()->where('slug', 'street')->firstOrFail();

    $routes = [
        ['home', []],
        ['about', []],
        ['portfolio.index', []],
        ['portfolio.show', ['series' => $street]],
        ['contact.show', []],
    ];

    foreach ($routes as [$routeName, $parameters]) {
        $response = $this->get(route($routeName, $parameters));

        $response->assertOk();
        $response->assertSee('/icon-sm.png', false);
        $response->assertSee('rel="icon"', false);
        $response->assertSee('rel="apple-touch-icon"', false);
        $response->assertSee('rel="manifest"', false);
        $response->assertSee('msapplication-TileImage', false);
        $response->assertSee('site.webmanifest', false);
    }
});

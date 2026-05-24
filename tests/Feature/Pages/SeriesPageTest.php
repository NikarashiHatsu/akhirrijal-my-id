<?php

use App\Models\Photo;
use App\Models\Profile;
use App\Models\Series;
use Database\Seeders\SeriesSeeder;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('local');
    Storage::fake('public');
    Profile::factory()->create();
    (new SeriesSeeder)->run();
});

it('renders a series detail page with photos, captions, and wraparound navigation', function () {
    $street = Series::query()->where('slug', 'street')->firstOrFail();

    $photos = Photo::factory()->count(3)->create([
        'series_id' => $street->id,
    ]);

    $response = $this->get(route('portfolio.show', $street));

    $response->assertOk();
    $response->assertSeeText($street->title);

    foreach ($photos as $photo) {
        $response->assertSeeText($photo->title);
    }

    $firstPhoto = $photos->first()->fresh();

    $response->assertSee('srcset=', false);
    $response->assertSee('480w', false);
    $response->assertSee('.webp', false);
    $response->assertSee($firstPhoto->lightboxUrl(), false);
    $response->assertDontSee('uploaded/original', false);

    $response->assertSee(route('portfolio.show', $street->nextSeries()), false);
    $response->assertSee(route('portfolio.show', $street->previousSeries()), false);
});

it('returns 404 for an unknown series slug', function () {
    $this->get('/portfolio/does-not-exist')->assertNotFound();
});

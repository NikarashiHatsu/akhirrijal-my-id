<?php

use App\Models\Photo;
use App\Models\Series;
use Illuminate\Database\QueryException;

it('persists the documented columns on a series', function () {
    $series = Series::create([
        'slug' => 'street',
        'title' => 'Street',
        'lead' => 'Honest, unscripted scenes from Indonesian streets — where light, noise, and humanity collide.',
        'short_description' => 'Honest, unscripted scenes from Indonesian streets.',
        'sort_order' => 1,
        'aspect_ratio' => '4/3',
        'cover_image_path' => 'series/street/cover.jpg',
        'cover_image_alt' => 'Quiet Jakarta sidewalk under warm light',
        'subhero_image_path' => 'series/street/subhero.jpg',
        'subhero_image_alt' => 'Quiet Jakarta sidewalk under warm light',
    ]);

    expect($series->refresh())
        ->slug->toBe('street')
        ->title->toBe('Street')
        ->aspect_ratio->toBe('4/3')
        ->sort_order->toBe(1);
});

it('enforces unique slugs', function () {
    Series::factory()->create(['slug' => 'street']);

    Series::factory()->create(['slug' => 'street']);
})->throws(QueryException::class);

it('exposes a hasMany relation to photos', function () {
    $series = Series::factory()->create();
    Photo::factory()->count(3)->create(['series_id' => $series->id]);

    expect($series->photos)->toHaveCount(3);
});

it('wraps around to the first series when retrieving the next series of the last one', function () {
    [$first, $second, $third] = collect([1, 2, 3])->map(
        fn (int $order) => Series::factory()->create(['sort_order' => $order]),
    )->all();

    expect($third->nextSeries()->is($first))->toBeTrue();
    expect($first->previousSeries()->is($third))->toBeTrue();
    expect($second->nextSeries()->is($third))->toBeTrue();
    expect($second->previousSeries()->is($first))->toBeTrue();
});

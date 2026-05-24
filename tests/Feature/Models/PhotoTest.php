<?php

use App\Models\Photo;
use App\Models\Series;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('persists the documented columns on a photo', function () {
    $series = Series::factory()->create();

    $photo = Photo::create([
        'series_id' => $series->id,
        'sort_order' => 1,
        'image_path' => 'photos/example.jpg',
        'disk' => 'public',
        'width' => 1600,
        'height' => 1067,
        'alt' => 'Quiet sidewalk under a single warm streetlight',
        'title' => 'The Last Lamp on Jalan Sabang',
        'story' => 'Past midnight on Jalan Sabang. The food stalls have folded for the night.',
        'location' => 'Jalan Sabang, Central Jakarta',
        'date_label' => 'September 2024',
        'taken_at' => '2024-09-15',
        'ratio' => 'portrait',
    ]);

    expect($photo->refresh())
        ->series_id->toBe($series->id)
        ->title->toBe('The Last Lamp on Jalan Sabang')
        ->width->toBe(1600)
        ->height->toBe(1067)
        ->ratio->toBe('portrait')
        ->taken_at->format('Y-m-d')->toBe('2024-09-15');
});

it('belongs to a series', function () {
    $series = Series::factory()->create();
    $photo = Photo::factory()->create(['series_id' => $series->id]);

    expect($photo->series)->not->toBeNull()
        ->and($photo->series->is($series))->toBeTrue();
});

it('exposes the public url of the uploaded image', function () {
    Storage::fake('public');

    $file = UploadedFile::fake()->image('frame.jpg', 1600, 1067);
    $path = $file->store('photos', 'public');

    $photo = Photo::factory()->create([
        'image_path' => $path,
        'disk' => 'public',
    ]);

    expect($photo->url())->toContain('/storage/photos/');
});

it('seeds an image via the factory using a faked uploaded image', function () {
    Storage::fake('public');

    $photo = Photo::factory()->create();

    Storage::disk('public')->assertExists($photo->image_path);
});

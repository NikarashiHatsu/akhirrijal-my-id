<?php

use App\Models\Photo;
use App\Models\Series;
use App\Services\PhotoImageProcessor;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('local');
    Storage::fake('public');
});

it('archives the original privately and generates public webp variants', function () {
    $series = Series::factory()->create();

    $photo = Photo::query()->create([
        'series_id' => $series->id,
        'sort_order' => 1,
        'image_path' => '',
        'disk' => 'public',
        'title' => 'Test frame',
        'ratio' => 'landscape',
    ]);

    $upload = UploadedFile::fake()->image('frame.jpg', 1600, 1067);
    $stagingPath = $upload->store('uploaded/staging', 'public');

    app(PhotoImageProcessor::class)->process($photo, $stagingPath);

    $photo->refresh();

    expect($photo->original_path)->toStartWith('uploaded/original/'.$photo->id.'/')
        ->and($photo->original_disk)->toBe('local')
        ->and($photo->variants)->toBeArray()
        ->and($photo->variants)->not->toBeEmpty()
        ->and($photo->image_path)->toStartWith('uploaded/compressed/'.$photo->id.'/')
        ->and($photo->image_path)->toEndWith('.webp')
        ->and($photo->width)->toBe(1600)
        ->and($photo->height)->toBe(1067);

    Storage::disk('local')->assertExists($photo->original_path);
    Storage::disk('public')->assertExists($photo->image_path);

    foreach ($photo->variants as $variant) {
        Storage::disk('public')->assertExists($variant['path']);
        expect($variant['path'])->toEndWith('.webp');
    }

    Storage::disk('public')->assertMissing($stagingPath);

    expect($photo->url())
        ->not->toContain('uploaded/original')
        ->toContain('/storage/uploaded/compressed/');
});

it('builds a srcset from compressed variants only', function () {
    $series = Series::factory()->create();

    $photo = Photo::query()->create([
        'series_id' => $series->id,
        'sort_order' => 1,
        'image_path' => '',
        'disk' => 'public',
        'title' => 'Test frame',
        'ratio' => 'landscape',
    ]);

    $upload = UploadedFile::fake()->image('frame.jpg', 1600, 1067);
    $stagingPath = $upload->store('uploaded/staging', 'public');

    app(PhotoImageProcessor::class)->process($photo, $stagingPath);

    $photo->refresh();

    expect($photo->srcset())
        ->toContain('480w')
        ->toContain('.webp')
        ->not->toContain('uploaded/original');

    expect($photo->lightboxUrl())
        ->toContain('/storage/uploaded/compressed/')
        ->not->toContain('uploaded/original');
});

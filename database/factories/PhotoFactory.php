<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\Series;
use App\Services\PhotoImageProcessor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;

/**
 * @extends Factory<Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ratio = fake()->randomElement(['landscape', 'landscape4', 'portrait', 'tall', 'square', 'pano']);
        [$width, $height] = match ($ratio) {
            'landscape' => [1600, 1067],
            'landscape4' => [1600, 1200],
            'portrait' => [1067, 1600],
            'tall' => [1280, 1600],
            'square' => [1400, 1400],
            'pano' => [1800, 900],
        };

        return [
            'series_id' => Series::factory(),
            'sort_order' => fake()->numberBetween(1, 12),
            'image_path' => '',
            'disk' => 'public',
            'width' => $width,
            'height' => $height,
            'alt' => fake()->sentence(),
            'title' => fake()->sentence(4),
            'story' => fake()->paragraph(),
            'location' => fake()->city(),
            'date_label' => fake()->monthName().' '.fake()->year(),
            'taken_at' => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'ratio' => $ratio,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Photo $photo): void {
            if (is_array($photo->variants) && $photo->variants !== []) {
                return;
            }

            if ($photo->image_path !== '' && $photo->variants === null) {
                return;
            }

            $upload = UploadedFile::fake()->image('frame.jpg', 1600, 1067);
            $stagingPath = $upload->store(config('photos.staging_directory', 'uploaded/staging'), 'public');

            app(PhotoImageProcessor::class)->process($photo, $stagingPath);
        });
    }
}

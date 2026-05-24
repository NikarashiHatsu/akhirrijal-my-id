<?php

namespace Database\Factories;

use App\Models\Photo;
use App\Models\Series;
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

        $file = UploadedFile::fake()->image('frame.jpg', $width, $height);
        $path = $file->store('photos', 'public');

        return [
            'series_id' => Series::factory(),
            'sort_order' => fake()->numberBetween(1, 12),
            'image_path' => $path,
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
}

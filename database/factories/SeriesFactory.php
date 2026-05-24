<?php

namespace Database\Factories;

use App\Models\Series;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Series>
 */
class SeriesFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->words(2, true);

        return [
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1000, 99999),
            'title' => Str::title($title),
            'lead' => fake()->sentence(20),
            'short_description' => fake()->sentence(),
            'sort_order' => fake()->unique()->numberBetween(1, 9999),
            'aspect_ratio' => fake()->randomElement(['4/3', '3/4', '16/10', '4/5']),
            'cover_image_path' => null,
            'cover_image_alt' => fake()->sentence(),
            'subhero_image_path' => null,
            'subhero_image_alt' => fake()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sort_order' => fake()->numberBetween(1, 99),
            'number_label' => str_pad((string) fake()->numberBetween(1, 99), 2, '0', STR_PAD_LEFT),
            'title' => fake()->catchPhrase(),
            'description' => fake()->paragraph(),
        ];
    }
}

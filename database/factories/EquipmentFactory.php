<?php

namespace Database\Factories;

use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sort_order' => fake()->numberBetween(1, 99),
            'badge_label' => fake()->words(2, true),
            'badge_value' => strtoupper(fake()->bothify('??##')),
            'category_label' => fake()->randomElement(['Body', 'Prime', 'Zoom', 'Finish']),
            'name' => 'Canon '.fake()->bothify('??-####'),
            'description' => fake()->paragraph(),
        ];
    }
}

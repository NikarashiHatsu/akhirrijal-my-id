<?php

namespace Database\Factories;

use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SocialLink>
 */
class SocialLinkFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $platform = fake()->randomElement(['email', 'whatsapp', 'instagram', 'website']);

        return [
            'platform' => $platform,
            'label' => ucfirst($platform).' · '.fake()->userName(),
            'url' => fake()->url(),
            'sort_order' => fake()->numberBetween(1, 99),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'alternate_name' => fake()->firstName(),
            'monogram' => fake()->firstName(),
            'job_title' => 'Photographer',
            'tagline' => fake()->catchPhrase(),
            'specializations' => 'Street · Human Interest · Landscape Photographer',
            'hero_lead' => 'Capturing authentic human moments, stories, and landscapes through visual storytelling.',
            'home_about_heading' => 'A documentary eye for outdoor and hospitality storytelling.',
            'home_selected_work_heading' => "Four disciplines,\none eye.",
            'bio' => fake()->paragraphs(3, true),
            'statement' => fake()->sentence(20),
            'location_city' => fake()->city(),
            'location_country' => fake()->country(),
            'availability_status' => 'Available worldwide',
            'email' => fake()->safeEmail(),
            'whatsapp_e164' => fake()->numerify('628##########'),
            'whatsapp_display' => '+62 838-2448-2936',
            'instagram_handle' => '@'.fake()->userName(),
            'instagram_url' => fake()->url(),
            'website_url' => fake()->url(),
            'hero_image_path' => null,
            'hero_image_alt' => fake()->sentence(),
            'about_portrait_image_path' => null,
            'about_portrait_image_alt' => fake()->sentence(),
            'about_subhero_image_path' => null,
            'about_subhero_image_alt' => fake()->sentence(),
            'portfolio_subhero_image_path' => null,
            'portfolio_subhero_image_alt' => fake()->sentence(),
            'contact_subhero_image_path' => null,
            'contact_subhero_image_alt' => fake()->sentence(),
            'crafted_in_label' => 'Crafted in Jakarta · Indonesia',
        ];
    }
}

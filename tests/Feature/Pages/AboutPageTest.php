<?php

use App\Models\Equipment;
use App\Models\Experience;
use App\Models\Profile;
use Database\Seeders\EquipmentSeeder;
use Database\Seeders\ExperienceSeeder;

beforeEach(function () {
    Profile::factory()->create();
    (new ExperienceSeeder)->run();
    (new EquipmentSeeder)->run();
});

it('renders the about page with bio, every experience card, and every equipment card', function () {
    $response = $this->get(route('about'));

    $response->assertOk();
    $response->assertSeeText('Behind the lens');

    foreach (Experience::query()->ordered()->pluck('title') as $title) {
        $response->assertSeeText($title);
    }

    foreach (Equipment::query()->ordered()->pluck('name') as $name) {
        $response->assertSeeText($name);
    }
});

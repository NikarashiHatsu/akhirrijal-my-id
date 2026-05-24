<?php

use App\Models\Profile;
use Database\Seeders\SocialLinkSeeder;

beforeEach(function () {
    Profile::factory()->create();
    (new SocialLinkSeeder)->run();
});

it('renders the contact page with form fields and direct details', function () {
    $response = $this->get(route('contact.show'));

    $response->assertOk();
    $response->assertSee('name="name"', false);
    $response->assertSee('name="email"', false);
    $response->assertSee('name="subject"', false);
    $response->assertSee('name="message"', false);
    $response->assertSee('name="company"', false);
    $response->assertSeeText('Available worldwide');
});

it('shows the confirmation banner when the status flash is set', function () {
    $response = $this->withSession(['status' => 'sent'])->get(route('contact.show'));

    $response->assertOk();
    $response->assertSeeText("I'll reply within two working days");
});

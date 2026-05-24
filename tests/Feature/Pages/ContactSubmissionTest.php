<?php

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Profile;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    Mail::fake();
    Profile::factory()->create([
        'email' => 'qothrul112358@gmail.com',
    ]);
});

it('persists a valid submission and queues the project-brief email', function () {
    $response = $this->post(route('contact.store'), [
        'name' => 'Maria Santos',
        'email' => 'maria@brand.com',
        'subject' => 'Mediterranean cruise · onboard photography',
        'message' => 'A few words about the story, dates, and location.',
    ]);

    $response->assertRedirect(route('contact.show'));
    $response->assertSessionHas('status', 'sent');

    $this->assertDatabaseHas(ContactMessage::class, [
        'name' => 'Maria Santos',
        'email' => 'maria@brand.com',
        'subject' => 'Mediterranean cruise · onboard photography',
    ]);

    Mail::assertQueued(ContactMessageReceived::class, function (ContactMessageReceived $mail) {
        return $mail->hasTo('qothrul112358@gmail.com');
    });
});

it('silently drops honeypot submissions without persisting or sending mail', function () {
    $response = $this->post(route('contact.store'), [
        'name' => 'Bot McSpammer',
        'email' => 'bot@spam.example',
        'subject' => 'Buy followers',
        'message' => 'Cheap rates today',
        'company' => 'definitely-a-bot-inc',
    ]);

    $response->assertRedirect(route('contact.show'));
    $response->assertSessionHas('status', 'sent');

    $this->assertDatabaseCount(ContactMessage::class, 0);
    Mail::assertNothingQueued();
});

it('redirects back with validation errors when required fields are missing', function () {
    $response = $this->from(route('contact.show'))->post(route('contact.store'), [
        'name' => '',
        'email' => 'not-an-email',
        'subject' => '',
        'message' => '',
    ]);

    $response->assertRedirect(route('contact.show'));
    $response->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

    $this->assertDatabaseCount(ContactMessage::class, 0);
    Mail::assertNothingQueued();
});

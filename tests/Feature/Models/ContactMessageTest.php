<?php

use App\Models\ContactMessage;

it('persists every column captured from the contact form submission', function () {
    $message = ContactMessage::create([
        'name' => 'Maria Santos',
        'email' => 'maria@brand.com',
        'subject' => 'Mediterranean cruise · onboard photography',
        'message' => 'A few words about the story, dates, and location.',
        'ip_address' => '203.0.113.42',
        'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 14_5)',
    ]);

    expect($message->refresh())
        ->name->toBe('Maria Santos')
        ->email->toBe('maria@brand.com')
        ->subject->toBe('Mediterranean cruise · onboard photography')
        ->message->toContain('story, dates, and location')
        ->ip_address->toBe('203.0.113.42')
        ->replied_at->toBeNull();
});

it('reports whether a message has been replied to', function () {
    $message = ContactMessage::factory()->create(['replied_at' => null]);
    expect($message->hasBeenReplied())->toBeFalse();

    $message->update(['replied_at' => now()]);
    expect($message->refresh()->hasBeenReplied())->toBeTrue();
});

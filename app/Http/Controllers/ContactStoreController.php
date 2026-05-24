<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactMessageRequest;
use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactStoreController extends Controller
{
    public function __invoke(StoreContactMessageRequest $request): RedirectResponse
    {
        if ($request->isHoneypotTripped()) {
            return redirect()
                ->route('contact.show')
                ->with('status', 'sent');
        }

        $payload = $request->safe()->except('company');

        $message = ContactMessage::create([
            ...$payload,
            'ip_address' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 1000),
        ]);

        $profileEmail = optional(Profile::query()->orderBy('id')->first())->email;
        if ($profileEmail) {
            Mail::to($profileEmail)->queue(new ContactMessageReceived($message));
        }

        return redirect()
            ->route('contact.show')
            ->with('status', 'sent');
    }
}

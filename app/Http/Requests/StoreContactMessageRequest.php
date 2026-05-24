<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'company' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Honeypot field — humans never see/fill the `company` input. Treat any
     * non-empty value as bot traffic so the controller can short-circuit
     * without persisting the row or notifying the photographer.
     */
    public function isHoneypotTripped(): bool
    {
        return filled($this->input('company'));
    }
}

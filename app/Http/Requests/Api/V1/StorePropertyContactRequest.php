<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StorePropertyContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware handles authorization
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required_without:whatsapp', 'nullable', 'string', 'max:20'],
            'whatsapp' => ['required_without:phone', 'nullable', 'string', 'max:20'],
            'is_whatsapp' => ['required', 'boolean'],
            'label' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'phone.required_without' => 'At least a phone number or a WhatsApp number must be provided.',
            'whatsapp.required_without' => 'At least a phone number or a WhatsApp number must be provided.',
        ];
    }
}

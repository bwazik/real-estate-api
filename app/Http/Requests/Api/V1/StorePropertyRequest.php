<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePropertyRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'purpose' => ['required', 'string', 'in:sale,rent,investment'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'bathrooms' => ['required', 'numeric', 'min:0'],
            'area_size' => ['required', 'numeric', 'min:0'],
            'floor_number' => ['nullable', 'integer'],
            'year_built' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'is_furnished' => ['required', 'boolean'],
            'status' => ['required', 'integer', 'in:0,1,2,3,4'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'features' => ['nullable', 'array'],
            'features.*' => ['exists:property_features,id'],
            // Images and contacts handling could be complex, but for now we define basic rules
            'images' => ['nullable', 'array'],
            'images.*.image_path' => ['required', 'string'],
            'images.*.is_main' => ['required', 'boolean'],
            'images.*.order' => ['required', 'integer'],
            'contacts' => ['nullable', 'array'],
            'contacts.*.phone' => ['required', 'string'],
            'contacts.*.whatsapp' => ['nullable', 'string'],
            'contacts.*.is_whatsapp' => ['required', 'boolean'],
            'contacts.*.label' => ['nullable', 'string'],
        ];
    }
}

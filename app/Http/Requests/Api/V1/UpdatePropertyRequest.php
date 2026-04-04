<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePropertyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'purpose' => ['sometimes', 'string', 'in:sale,rent,investment'],
            'property_type_id' => ['sometimes', 'exists:property_types,id'],
            'area_id' => ['sometimes', 'exists:areas,id'],
            'bedrooms' => ['sometimes', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'numeric', 'min:0'],
            'area_size' => ['sometimes', 'numeric', 'min:0'],
            'floor_number' => ['nullable', 'integer'],
            'year_built' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'is_furnished' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'integer', 'in:0,1,2,3,4'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'features' => ['nullable', 'array'],
            'features.*' => ['exists:property_features,id'],
            'images' => ['nullable', 'array'],
            'images.*.id' => ['nullable', 'exists:property_images,id'],
            'images.*.image_path' => ['required_with:images.*.is_main', 'string'],
            'images.*.is_main' => ['required_with:images.*.image_path', 'boolean'],
            'images.*.order' => ['required_with:images.*.image_path', 'integer'],
            'contacts' => ['nullable', 'array'],
            'contacts.*.id' => ['nullable', 'exists:property_contacts,id'],
            'contacts.*.phone' => ['required_with:contacts.*.is_whatsapp', 'string'],
            'contacts.*.whatsapp' => ['nullable', 'string'],
            'contacts.*.is_whatsapp' => ['required_with:contacts.*.phone', 'boolean'],
            'contacts.*.label' => ['nullable', 'string'],
        ];
    }
}

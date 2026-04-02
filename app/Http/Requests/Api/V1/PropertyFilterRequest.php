<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class PropertyFilterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'property_type_id' => ['nullable', 'exists:property_types,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'area_id' => ['nullable', 'exists:areas,id'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'min_bedrooms' => ['nullable', 'integer', 'min:0'],
            'max_bedrooms' => ['nullable', 'integer', 'min:0'],
            'min_area_size' => ['nullable', 'numeric', 'min:0'],
            'max_area_size' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'in:available,sold,rented'],
            'is_furnished' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'string', 'in:price_asc,price_desc,newest,oldest,area_size'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }
}

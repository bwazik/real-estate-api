<?php

namespace App\Http\Requests\Api\V1;

class PropertyFilterRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'property_type_slug' => ['nullable', 'string', 'exists:property_types,slug'],
            'city_slug' => ['nullable', 'string', 'exists:cities,slug'],
            'area_slug' => ['nullable', 'string', 'exists:areas,slug'],
            'offer_type' => ['nullable', 'string', 'max:100'],
            'purpose' => ['nullable', 'string', 'in:sale,rent,investment'],
            'status' => ['nullable', 'integer', 'in:0,1,2,3,4'],
            'listing_status' => ['nullable', 'string', 'max:100'],
            'property_category' => ['nullable', 'string', 'max:100'],
            'city_name' => ['nullable', 'string', 'max:150'],
            'district_name' => ['nullable', 'string', 'max:150'],
            'offer_number' => ['nullable', 'string', 'max:100'],
            'advertiser_name' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
            'min_bedrooms' => ['nullable', 'integer', 'min:0'],
            'max_bedrooms' => ['nullable', 'integer', 'min:0'],
            'min_area_size' => ['nullable', 'numeric', 'min:0'],
            'max_area_size' => ['nullable', 'numeric', 'min:0'],
            'is_furnished' => ['nullable', 'boolean'],
            'sort' => ['nullable', 'string', 'in:price_asc,price_desc,newest,oldest,area_size,ad_date_desc'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ];
    }
}

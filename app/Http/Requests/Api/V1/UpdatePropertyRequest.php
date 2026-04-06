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
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'purpose' => ['sometimes', 'string', 'in:sale,rent,investment'],
            'property_type_id' => ['sometimes', 'exists:property_types,id'],
            'area_id' => ['sometimes', 'exists:areas,id'],
            'ad_date' => ['sometimes', 'nullable', 'date'],
            'offer_type' => ['sometimes', 'nullable', 'string', 'max:100'],
            'listing_status' => ['sometimes', 'nullable', 'string', 'max:100'],
            'property_category' => ['sometimes', 'nullable', 'string', 'max:100'],
            'offer_attribute' => ['sometimes', 'nullable', 'string', 'max:100'],
            'offer_number' => ['sometimes', 'nullable', 'string', 'max:100'],
            'property_name' => ['sometimes', 'string', 'max:255'],
            'property_number' => ['sometimes', 'nullable', 'string', 'max:100'],
            'property_area_text' => ['sometimes', 'nullable', 'string', 'max:100'],
            'in_kind_registration' => ['sometimes', 'nullable', 'string', 'max:255'],
            'platform_code' => ['sometimes', 'nullable', 'string', 'max:255'],
            'plan_number' => ['sometimes', 'nullable', 'string', 'max:100'],
            'deed_number' => ['sometimes', 'nullable', 'string', 'max:100'],
            'deed_date' => ['sometimes', 'nullable', 'date'],
            'deed_status' => ['sometimes', 'nullable', 'string', 'max:100'],
            'facade_direction' => ['sometimes', 'nullable', 'string', 'max:100'],
            'facades_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'advertiser_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'fal_license_number' => ['sometimes', 'nullable', 'string', 'max:100'],
            'advertising_license_number' => ['sometimes', 'nullable', 'string', 'max:100'],
            'property_address' => ['sometimes', 'nullable', 'string', 'max:500'],
            'country' => ['sometimes', 'nullable', 'string', 'max:100'],
            'city_name' => ['sometimes', 'nullable', 'string', 'max:150'],
            'district_name' => ['sometimes', 'nullable', 'string', 'max:150'],
            'street' => ['sometimes', 'nullable', 'string', 'max:255'],
            'building_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'floors_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'apartment_number' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'map_location' => ['sometimes', 'nullable', 'string'],
            'units_and_facilities' => ['sometimes', 'nullable', 'string'],
            'apartments_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'bedrooms' => ['sometimes', 'integer', 'min:0'],
            'living_rooms_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'kitchens_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'bathrooms' => ['sometimes', 'numeric', 'min:0', 'max:99.9'],
            'parking_spaces' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'warehouses_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'has_maids_room' => ['sometimes', 'boolean'],
            'has_drivers_room' => ['sometimes', 'boolean'],
            'entrances_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'annexes_count' => ['sometimes', 'nullable', 'integer', 'min:0'],
            'area_size' => ['sometimes', 'numeric', 'min:0'],
            'floor_number' => ['nullable', 'integer'],
            'year_built' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'is_furnished' => ['sometimes', 'boolean'],
            'status' => ['sometimes', 'integer', 'in:0,1,2,3,4'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'income' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'highest_bid' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'brokerage_fee' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'insurance_amount' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'obligations' => ['sometimes', 'nullable', 'string'],
            'advantages' => ['sometimes', 'nullable', 'string'],
            'ad_information' => ['sometimes', 'nullable', 'string'],
            'features' => ['nullable', 'array'],
            'features.*' => ['exists:property_features,id'],
            'contacts' => ['nullable', 'array'],
            'contacts.*.id' => ['nullable', 'exists:property_contacts,id'],
            'contacts.*.phone' => ['required_with:contacts.*.is_whatsapp', 'string'],
            'contacts.*.whatsapp' => ['nullable', 'string'],
            'contacts.*.is_whatsapp' => ['required_with:contacts.*.phone', 'boolean'],
            'contacts.*.label' => ['nullable', 'string'],
        ];
    }
}

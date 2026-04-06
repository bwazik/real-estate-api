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
            'title' => ['nullable', 'string', 'max:255', 'required_without:property_name'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'purpose' => ['required', 'string', 'in:sale,rent,investment'],
            'property_type_id' => ['required', 'exists:property_types,id'],
            'area_id' => ['required', 'exists:areas,id'],
            'ad_date' => ['nullable', 'date'],
            'offer_type' => ['nullable', 'string', 'max:100'],
            'listing_status' => ['nullable', 'string', 'max:100'],
            'property_category' => ['nullable', 'string', 'max:100'],
            'offer_attribute' => ['nullable', 'string', 'max:100'],
            'offer_number' => ['nullable', 'string', 'max:100'],
            'property_name' => ['nullable', 'string', 'max:255', 'required_without:title'],
            'property_number' => ['nullable', 'string', 'max:100'],
            'property_area_text' => ['nullable', 'string', 'max:100'],
            'in_kind_registration' => ['nullable', 'string', 'max:255'],
            'platform_code' => ['nullable', 'string', 'max:255'],
            'plan_number' => ['nullable', 'string', 'max:100'],
            'deed_number' => ['nullable', 'string', 'max:100'],
            'deed_date' => ['nullable', 'date'],
            'deed_status' => ['nullable', 'string', 'max:100'],
            'facade_direction' => ['nullable', 'string', 'max:100'],
            'facades_count' => ['nullable', 'integer', 'min:0'],
            'advertiser_name' => ['nullable', 'string', 'max:255'],
            'fal_license_number' => ['nullable', 'string', 'max:100'],
            'advertising_license_number' => ['nullable', 'string', 'max:100'],
            'property_address' => ['nullable', 'string', 'max:500'],
            'country' => ['nullable', 'string', 'max:100'],
            'city_name' => ['nullable', 'string', 'max:150'],
            'district_name' => ['nullable', 'string', 'max:150'],
            'street' => ['nullable', 'string', 'max:255'],
            'building_name' => ['nullable', 'string', 'max:255'],
            'floors_count' => ['nullable', 'integer', 'min:0'],
            'apartment_number' => ['nullable', 'integer', 'min:0'],
            'map_location' => ['nullable', 'string'],
            'units_and_facilities' => ['nullable', 'string'],
            'apartments_count' => ['nullable', 'integer', 'min:0'],
            'bedrooms' => ['required', 'integer', 'min:0'],
            'living_rooms_count' => ['nullable', 'integer', 'min:0'],
            'kitchens_count' => ['nullable', 'integer', 'min:0'],
            'bathrooms' => ['required', 'numeric', 'min:0', 'max:99.9'],
            'parking_spaces' => ['nullable', 'integer', 'min:0'],
            'warehouses_count' => ['nullable', 'integer', 'min:0'],
            'has_maids_room' => ['nullable', 'boolean'],
            'has_drivers_room' => ['nullable', 'boolean'],
            'entrances_count' => ['nullable', 'integer', 'min:0'],
            'annexes_count' => ['nullable', 'integer', 'min:0'],
            'area_size' => ['required', 'numeric', 'min:0'],
            'floor_number' => ['nullable', 'integer'],
            'year_built' => ['nullable', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'is_furnished' => ['required', 'boolean'],
            'status' => ['required', 'integer', 'in:0,1,2,3,4'],
            'latitude' => ['nullable', 'numeric', 'between:-90,90'],
            'longitude' => ['nullable', 'numeric', 'between:-180,180'],
            'income' => ['nullable', 'numeric', 'min:0'],
            'highest_bid' => ['nullable', 'numeric', 'min:0'],
            'brokerage_fee' => ['nullable', 'numeric', 'min:0'],
            'insurance_amount' => ['nullable', 'numeric', 'min:0'],
            'obligations' => ['nullable', 'string'],
            'advantages' => ['nullable', 'string'],
            'ad_information' => ['nullable', 'string'],
            'features' => ['nullable', 'array'],
            'features.*' => ['exists:property_features,id'],
            'contacts' => ['nullable', 'array'],
            'contacts.*.phone' => ['required', 'string'],
            'contacts.*.whatsapp' => ['nullable', 'string'],
            'contacts.*.is_whatsapp' => ['required', 'boolean'],
            'contacts.*.label' => ['nullable', 'string'],
        ];
    }
}

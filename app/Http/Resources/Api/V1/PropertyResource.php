<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Property $resource
 */
class PropertyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'slug' => $this->resource->slug,
            'title' => $this->resource->title,
            'ad_date' => $this->resource->ad_date?->format('Y-m-d H:i:s'),
            'property_name' => $this->resource->property_name,
            'offer_type' => $this->resource->offer_type,
            'listing_status' => $this->resource->listing_status,
            'property_category' => $this->resource->property_category,
            'offer_attribute' => $this->resource->offer_attribute,
            'offer_number' => $this->resource->offer_number,
            'property_number' => $this->resource->property_number,
            'property_area_text' => $this->resource->property_area_text,
            'in_kind_registration' => $this->resource->in_kind_registration,
            'platform_code' => $this->resource->platform_code,
            'plan_number' => $this->resource->plan_number,
            'deed_number' => $this->resource->deed_number,
            'deed_date' => $this->resource->deed_date,
            'deed_status' => $this->resource->deed_status,
            'facade_direction' => $this->resource->facade_direction,
            'facades_count' => (int) $this->resource->facades_count,
            'advertiser_name' => $this->resource->advertiser_name,
            'fal_license_number' => $this->resource->fal_license_number,
            'advertising_license_number' => $this->resource->advertising_license_number,
            'property_address' => $this->resource->property_address,
            'country' => $this->resource->country,
            'city_name' => $this->resource->city_name,
            'district_name' => $this->resource->district_name,
            'street' => $this->resource->street,
            'building_name' => $this->resource->building_name,
            'floors_count' => (int) $this->resource->floors_count,
            'apartment_number' => (int) $this->resource->apartment_number,
            'map_location' => $this->resource->map_location,
            'units_and_facilities' => $this->resource->units_and_facilities,
            'apartments_count' => (int) $this->resource->apartments_count,
            'description' => $this->resource->description,
            'purpose' => $this->resource->purpose?->value,
            'price' => (float) $this->resource->price,
            'bedrooms' => (int) $this->resource->bedrooms,
            'living_rooms_count' => (int) $this->resource->living_rooms_count,
            'kitchens_count' => (int) $this->resource->kitchens_count,
            'bathrooms' => (float) $this->resource->bathrooms,
            'parking_spaces' => (int) $this->resource->parking_spaces,
            'warehouses_count' => (int) $this->resource->warehouses_count,
            'has_maids_room' => (bool) $this->resource->has_maids_room,
            'has_drivers_room' => (bool) $this->resource->has_drivers_room,
            'entrances_count' => (int) $this->resource->entrances_count,
            'annexes_count' => (int) $this->resource->annexes_count,
            'area_size' => (float) $this->resource->area_size,
            'floor_number' => (int) $this->resource->floor_number,
            'year_built' => (int) $this->resource->year_built,
            'is_furnished' => (bool) $this->resource->is_furnished,
            'status' => $this->resource->status?->label(),
            'status_value' => $this->resource->status?->value,
            'latitude' => $this->resource->latitude !== null ? (float) $this->resource->latitude : null,
            'longitude' => $this->resource->longitude !== null ? (float) $this->resource->longitude : null,
            'income' => (float) $this->resource->income,
            'highest_bid' => (float) $this->resource->highest_bid,
            'brokerage_fee' => (float) $this->resource->brokerage_fee,
            'insurance_amount' => (float) $this->resource->insurance_amount,
            'obligations' => $this->resource->obligations,
            'advantages' => $this->resource->advantages,
            'ad_information' => $this->resource->ad_information,
            'views_count' => (int) $this->resource->views_count,
            'created_at' => $this->resource->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at?->format('Y-m-d H:i:s'),

            'type' => new PropertyTypeResource($this->whenLoaded('propertyType')),
            'area' => new AreaResource($this->whenLoaded('area')),
            'user' => [
                'uuid' => $this->resource->user?->uuid,
                'name' => $this->resource->user?->name,
            ],
            'features' => PropertyFeatureResource::collection($this->whenLoaded('features')),
            'images' => $this->resource->images->map(fn ($image) => [
                'uuid' => $image->uuid,
                'path' => $image->image_path,
                'is_main' => (bool) $image->is_main,
                'order' => (int) $image->order,
            ]),
            'contacts' => $this->resource->contacts->map(fn ($contact) => [
                'uuid' => $contact->uuid,
                'phone' => $contact->phone,
                'whatsapp' => $contact->whatsapp,
                'is_whatsapp' => (bool) $contact->is_whatsapp,
                'label' => $contact->label,
            ]),
        ];
    }
}

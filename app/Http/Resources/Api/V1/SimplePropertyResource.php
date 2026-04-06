<?php

namespace App\Http\Resources\Api\V1;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property Property $resource
 */
class SimplePropertyResource extends JsonResource
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
            'offer_number' => $this->resource->offer_number,
            'purpose' => $this->resource->purpose?->value,
            'status' => $this->resource->status?->label(),
            'price' => (float) $this->resource->price,
            'bedrooms' => (int) $this->resource->bedrooms,
            'bathrooms' => (float) $this->resource->bathrooms,
            'area_size' => (float) $this->resource->area_size,
            'is_furnished' => (bool) $this->resource->is_furnished,
            'city_name' => $this->resource->city_name,
            'district_name' => $this->resource->district_name,
            'type' => $this->resource->propertyType->name ?? null,
            'area' => $this->resource->area->name ?? null,
            'city' => $this->resource->area->city->name ?? null,
            'main_image' => $this->resource->images->isNotEmpty()
                ? asset('storage/' . ($this->resource->images->where('is_main', true)->first()->image_path ?? $this->resource->images->first()->image_path))
                : null,
            'created_at' => $this->resource->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}

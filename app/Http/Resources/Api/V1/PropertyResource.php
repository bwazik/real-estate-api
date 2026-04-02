<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Property $resource
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
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'slug' => $this->resource->slug,
            'description' => $this->resource->description,
            'price' => (float) $this->resource->price,
            'bedrooms' => (int) $this->resource->bedrooms,
            'bathrooms' => (float) $this->resource->bathrooms,
            'area_size' => (float) $this->resource->area_size,
            'floor_number' => (int) $this->resource->floor_number,
            'year_built' => (int) $this->resource->year_built,
            'is_furnished' => (bool) $this->resource->is_furnished,
            'status' => $this->resource->status,
            'latitude' => (float) $this->resource->latitude,
            'longitude' => (float) $this->resource->longitude,
            'views_count' => (int) $this->resource->views_count,
            'created_at' => $this->resource->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->resource->updated_at?->format('Y-m-d H:i:s'),

            'type' => [
                'id' => $this->resource->propertyType?->id,
                'name' => $this->resource->propertyType?->name,
            ],
            'area' => [
                'id' => $this->resource->area?->id,
                'name' => $this->resource->area?->name,
                'city' => [
                    'id' => $this->resource->area?->city?->id,
                    'name' => $this->resource->area?->city?->name,
                ],
            ],
            'user' => [
                'id' => $this->resource->user?->id,
                'name' => $this->resource->user?->name,
            ],
            'features' => $this->resource->features->map(fn($feature) => [
                'id' => $feature->id,
                'name' => $feature->name,
                'icon' => $feature->icon,
            ]),
            'images' => $this->resource->images->map(fn($image) => [
                'id' => $image->id,
                'path' => $image->image_path,
                'is_main' => (bool) $image->is_main,
                'order' => (int) $image->order,
            ]),
            'contacts' => $this->resource->contacts->map(fn($contact) => [
                'id' => $contact->id,
                'phone' => $contact->phone,
                'whatsapp' => $contact->whatsapp,
                'is_whatsapp' => (bool) $contact->is_whatsapp,
                'label' => $contact->label,
            ]),
        ];
    }
}

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
            'description' => $this->resource->description,
            'purpose' => $this->resource->purpose->value,
            'price' => (float) $this->resource->price,
            'bedrooms' => (int) $this->resource->bedrooms,
            'bathrooms' => (float) $this->resource->bathrooms,
            'area_size' => (float) $this->resource->area_size,
            'floor_number' => (int) $this->resource->floor_number,
            'year_built' => (int) $this->resource->year_built,
            'is_furnished' => (bool) $this->resource->is_furnished,
            'status' => $this->resource->status->label(),
            'latitude' => (float) $this->resource->latitude,
            'longitude' => (float) $this->resource->longitude,
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

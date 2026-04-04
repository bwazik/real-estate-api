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
            'purpose' => $this->resource->purpose->value,
            'price' => (float) $this->resource->price,
            'bedrooms' => (int) $this->resource->bedrooms,
            'bathrooms' => (float) $this->resource->bathrooms,
            'area_size' => (float) $this->resource->area_size,
            'is_furnished' => (bool) $this->resource->is_furnished,
            'status' => $this->resource->status->label(),
            'type' => $this->resource->propertyType->name ?? null,
            'area' => $this->resource->area->name ?? null,
            'city' => $this->resource->area->city->name ?? null,
            'main_image' => $this->resource->images->where('is_main', true)->first()->image_path ?? $this->resource->images->first()->image_path ?? null,
            'created_at' => $this->resource->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}

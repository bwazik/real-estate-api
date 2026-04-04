<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\PropertyFeature $resource
 */
class PropertyFeatureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'id'   => $this->resource->id,
            'uuid' => $this->resource->uuid,
            'name' => $this->resource->name,
            'icon' => $this->resource->icon ?? null,
        ];
    }
}

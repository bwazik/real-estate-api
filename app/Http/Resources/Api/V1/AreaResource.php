<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property \App\Models\Area $resource
 */
class AreaResource extends JsonResource
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
            'slug' => $this->resource->slug,
            'name' => $this->resource->name,
            'city' => new CityResource($this->whenLoaded('city')),
        ];
    }
}

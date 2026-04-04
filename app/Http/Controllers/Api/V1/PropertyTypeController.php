<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\PropertyTypeResource;
use App\Models\PropertyType;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PropertyTypeController extends BaseApiController
{
    /**
     * Display a listing of the property types.
     */
    public function index(): JsonResponse
    {
        $cache = Cache::supportsTags() ? Cache::tags(['static_data']) : Cache::getFacadeRoot();

        $types = $cache->remember('property_types', 3600, function () {
            return PropertyType::all();
        });

        return $this->successResponse(
            PropertyTypeResource::collection($types),
            'Property types retrieved successfully.'
        );
    }
}

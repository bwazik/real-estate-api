<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\AreaResource;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class AreaController extends BaseApiController
{
    /**
     * Display a listing of the areas.
     */
    public function index(): JsonResponse
    {
        $cache = Cache::supportsTags() ? Cache::tags(['static_data']) : Cache::getFacadeRoot();

        $areas = $cache->remember('areas', 3600, function () {
            return Area::all();
        });

        return $this->successResponse(
            AreaResource::collection($areas),
            'Areas retrieved successfully.'
        );
    }

    /**
     * Display areas of a specific city.
     */
    public function cityAreas(City $city): JsonResponse
    {
        $cache = Cache::supportsTags() ? Cache::tags(['static_data']) : Cache::getFacadeRoot();

        $areas = $cache->remember("city_{$city->slug}_areas", 3600, function () use ($city) {
            return $city->areas()->with('city')->get();
        });

        return $this->successResponse(
            AreaResource::collection($areas),
            "Areas for city {$city->name} retrieved successfully."
        );
    }
}

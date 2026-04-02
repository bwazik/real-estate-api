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
        $areas = Cache::remember('areas', 3600, function () {
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
        $areas = Cache::remember("city_{$city->id}_areas", 3600, function () use ($city) {
            return $city->areas;
        });

        return $this->successResponse(
            AreaResource::collection($areas),
            "Areas for city {$city->name} retrieved successfully."
        );
    }
}

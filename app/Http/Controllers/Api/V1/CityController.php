<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\CityResource;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class CityController extends BaseApiController
{
    /**
     * Display a listing of the cities.
     */
    public function index(): JsonResponse
    {
        $cache = Cache::supportsTags() ? Cache::tags(['static_data']) : Cache::getFacadeRoot();

        $cities = $cache->remember('cities', 3600, function () {
            return City::all();
        });

        return $this->successResponse(
            CityResource::collection($cities),
            'Cities retrieved successfully.'
        );
    }
}

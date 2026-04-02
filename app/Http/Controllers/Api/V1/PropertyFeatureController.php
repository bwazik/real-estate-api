<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\Api\V1\PropertyFeatureResource;
use App\Models\PropertyFeature;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class PropertyFeatureController extends BaseApiController
{
    /**
     * Display a listing of the property features.
     */
    public function index(): JsonResponse
    {
        $features = Cache::remember('property_features', 3600, function () {
            return PropertyFeature::all();
        });

        return $this->successResponse(
            PropertyFeatureResource::collection($features),
            'Property features retrieved successfully.'
        );
    }
}

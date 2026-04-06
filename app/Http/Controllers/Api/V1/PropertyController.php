<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\PropertyFilterRequest;
use App\Http\Requests\Api\V1\StorePropertyRequest;
use App\Http\Requests\Api\V1\UpdatePropertyRequest;
use App\Http\Resources\Api\V1\PropertyCollection;
use App\Http\Resources\Api\V1\PropertyResource;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PropertyController extends BaseApiController
{
    /**
     * Display a listing of the properties.
     */
    public function index(PropertyFilterRequest $request): JsonResponse
    {
        $properties = Property::query()
            ->select([
                'id', 'slug', 'property_name', 'listing_status', 'property_category', 'offer_type',
                'price', 'city_name', 'district_name', 'ad_date', 'created_at',
                'purpose', 'status', 'property_type_id', 'area_id',
                'title', 'bedrooms', 'bathrooms', 'area_size', 'is_furnished',
            ])
            ->with([
                'propertyType:id,name,slug',
                'area:id,name,slug,city_id',
                'area.city:id,name,slug',
                'images' => fn ($q) => $q->select(['id', 'property_id', 'image_path', 'is_main'])->where('is_main', true),
            ])
            ->filter($request->validated())
            ->paginate($request->integer('per_page', 15));

        return $this->successResponse(new PropertyCollection($properties), 'Properties retrieved successfully.');
    }

    /**
     * Store a newly created property in storage.
     */
    public function store(StorePropertyRequest $request): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $nameSource = $data['property_name'] ?? $data['title'] ?? null;

                if ($nameSource === null) {
                    return $this->errorResponse('Property name is required.', 422);
                }

                $data['property_name'] = $nameSource;
                $data['user_id'] = $request->user()->id;
                $data['title'] = $nameSource;
                $data['slug'] = Str::slug($nameSource).'-'.Str::random(5);

                $property = Property::create($data);

                if ($request->has('features')) {
                    $property->features()->sync($request->features);
                }

                if ($request->has('contacts')) {
                    $property->contacts()->createMany($request->contacts);
                }

                return $this->successResponse(
                    new PropertyResource($property->load(['propertyType', 'area.city', 'features', 'images', 'contacts'])),
                    'Property created successfully.',
                    201
                );
            });
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to create property: '.$e->getMessage(), 500);
        }
    }

    /**
     * Display the specified property.
     */
    public function show(Property $property): JsonResponse
    {
        $property->load(['propertyType', 'area.city', 'user', 'features', 'images', 'contacts']);
        $property->increment('views_count');

        return $this->successResponse(new PropertyResource($property), 'Property retrieved successfully.');
    }

    /**
     * Update the specified property in storage.
     */
    public function update(UpdatePropertyRequest $request, Property $property): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $property) {
                $data = $request->validated();

                if ($request->has('property_name')) {
                    $data['title'] = $data['property_name'];
                    $data['slug'] = Str::slug($data['property_name']).'-'.Str::random(5);
                } elseif ($request->has('title') && ! empty($data['title'])) {
                    $data['property_name'] = $data['title'];
                    $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
                }

                $property->update($data);

                if ($request->has('features')) {
                    $property->features()->sync($request->features);
                }

                if ($request->has('contacts')) {
                    $property->contacts()->delete();
                    $property->contacts()->createMany($request->contacts);
                }

                return $this->successResponse(
                    new PropertyResource($property->load(['propertyType', 'area.city', 'features', 'images', 'contacts'])),
                    'Property updated successfully.'
                );
            });
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update property: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified property from storage.
     */
    public function destroy(Property $property): JsonResponse
    {
        try {
            $property->delete();

            return $this->successResponse(null, 'Property deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete property.', 500);
        }
    }
}

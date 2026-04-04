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
                'id', 'slug', 'title', 'purpose', 'price', 'bedrooms', 'bathrooms', 
                'area_size', 'is_furnished', 'status', 'property_type_id', 'area_id', 'created_at'
            ])
            ->with([
                'propertyType:id,name,slug',
                'area:id,name,slug,city_id',
                'area.city:id,name,slug',
                'images' => fn ($q) => $q->select(['id', 'property_id', 'image_path', 'is_main'])->where('is_main', true)
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
                $data['user_id'] = $request->user()->id;
                $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);

                $property = Property::create($data);

                if ($request->has('features')) {
                    $property->features()->sync($request->features);
                }

                if ($request->has('images')) {
                    $property->images()->createMany($request->images);
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

                if ($request->has('title')) {
                    $data['slug'] = Str::slug($data['title']).'-'.Str::random(5);
                }

                $property->update($data);

                if ($request->has('features')) {
                    $property->features()->sync($request->features);
                }

                if ($request->has('images')) {
                    // Simple replacement logic for demo; in production, consider more surgical updates
                    $property->images()->delete();
                    $property->images()->createMany($request->images);
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
            return $this->errorResponse('Failed to update property: '.$e->getMessage(), 500);
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

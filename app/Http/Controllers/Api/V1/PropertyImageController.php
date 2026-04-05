<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StorePropertyImageRequest;
use App\Http\Resources\Api\V1\PropertyResource;
use App\Models\Property;
use App\Models\PropertyImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PropertyImageController extends BaseApiController
{
    /**
     * Upload multiple images for a property.
     */
    public function store(StorePropertyImageRequest $request, Property $property): JsonResponse
    {
        try {
            return DB::transaction(function () use ($request, $property) {
                $images = [];
                $lastOrder = $property->images()->max('order') ?? 0;

                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store("properties/{$property->id}", 'public');

                    $images[] = [
                        'property_id' => $property->id,
                        'image_path' => $path,
                        'is_main' => false, // Default to false
                        'order' => $lastOrder + $index + 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                foreach ($images as $imageData) {
                    $property->images()->create([
                        'image_path' => $imageData['image_path'],
                        'is_main' => $imageData['is_main'],
                        'order' => $imageData['order'],
                    ]);
                }

                // If no main image exists, set the first uploaded one as main
                if (!$property->images()->where('is_main', true)->exists()) {
                    $property->images()->first()->update(['is_main' => true]);
                }

                return $this->successResponse(
                    new PropertyResource($property->load('images')),
                    'Images uploaded successfully.',
                    201
                );
            });
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to upload images: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Delete a single image.
     */
    public function destroy(Property $property, PropertyImage $image): JsonResponse
    {
        try {
            if ($image->property_id !== $property->id) {
                return $this->errorResponse('Image does not belong to this property.', 403);
            }

            // Delete from storage
            Storage::disk('public')->delete($image->image_path);

            // Delete from database
            $isMain = $image->is_main;
            $image->delete();

            // If we deleted the main image, set a new one if possible
            if ($isMain) {
                $nextImage = $property->images()->first();
                if ($nextImage) {
                    $nextImage->update(['is_main' => true]);
                }
            }

            return $this->successResponse(null, 'Image deleted successfully.');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete image.', 500);
        }
    }

    /**
     * Set an image as main.
     */
    public function setMain(Property $property, PropertyImage $image): JsonResponse
    {
        try {
            if ($image->property_id !== $property->id) {
                return $this->errorResponse('Image does not belong to this property.', 403);
            }

            return DB::transaction(function () use ($property, $image) {
                // Reset all images for this property
                $property->images()->update(['is_main' => false]);

                // Set the selected one as main
                $image->update(['is_main' => true]);

                return $this->successResponse(
                    new PropertyResource($property->load('images')),
                    'Main image updated successfully.'
                );
            });
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to set main image.', 500);
        }
    }
}

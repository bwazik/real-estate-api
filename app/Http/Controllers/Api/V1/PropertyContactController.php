<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\StorePropertyContactRequest;
use App\Http\Requests\Api\V1\UpdatePropertyContactRequest;
use App\Http\Resources\Api\V1\PropertyResource;
use App\Models\Property;
use App\Models\PropertyContact;
use Illuminate\Http\JsonResponse;

class PropertyContactController extends BaseApiController
{
    /**
     * Add a new contact to a property.
     */
    public function store(StorePropertyContactRequest $request, Property $property): JsonResponse
    {
        try {
            $property->contacts()->create($request->validated());

            return $this->successResponse(
                new PropertyResource($property->load(['propertyType', 'area.city', 'features', 'images', 'contacts'])),
                'Contact added successfully.',
                201
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to add contact: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Update a specific contact.
     */
    public function update(UpdatePropertyContactRequest $request, Property $property, PropertyContact $contact): JsonResponse
    {
        try {
            if ($contact->property_id !== $property->id) {
                return $this->errorResponse('Contact does not belong to this property.', 403);
            }

            $contact->update($request->validated());

            return $this->successResponse(
                new PropertyResource($property->load(['propertyType', 'area.city', 'features', 'images', 'contacts'])),
                'Contact updated successfully.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update contact.', 500);
        }
    }

    /**
     * Remove a contact from a property.
     */
    public function destroy(Property $property, PropertyContact $contact): JsonResponse
    {
        try {
            if ($contact->property_id !== $property->id) {
                return $this->errorResponse('Contact does not belong to this property.', 403);
            }

            $contact->delete();

            return $this->successResponse(
                new PropertyResource($property->load(['propertyType', 'area.city', 'features', 'images', 'contacts'])),
                'Contact deleted successfully.'
            );
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to delete contact.', 500);
        }
    }
}

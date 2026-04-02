<?php

namespace App\Models;

use Database\Factories\PropertyFeatureFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['name', 'icon'])]
class PropertyFeature extends Model
{
    /** @use HasFactory<PropertyFeatureFactory> */
    use HasFactory;

    /**
     * Get the properties that have this feature.
     */
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'property_feature_property');
    }
}

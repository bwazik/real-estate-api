<?php

namespace App\Models;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'title',
    'slug',
    'description',
    'price',
    'property_type_id',
    'area_id',
    'bedrooms',
    'bathrooms',
    'area_size',
    'floor_number',
    'year_built',
    'is_furnished',
    'status',
    'latitude',
    'longitude',
    'views_count',
    'user_id',
])]
class Property extends Model
{
    /** @use HasFactory<PropertyFactory> */
    use HasFactory, SoftDeletes;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'bathrooms' => 'decimal:1',
            'area_size' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'is_furnished' => 'boolean',
            'bedrooms' => 'integer',
            'floor_number' => 'integer',
            'year_built' => 'integer',
            'views_count' => 'integer',
        ];
    }

    /**
     * Scope a query to only include active/available properties.
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope a query to only include active properties (alias for available).
     */
    public function scopeActive(Builder $query): Builder
    {
        return $this->scopeAvailable($query);
    }

    /**
     * Scope a query to filter results based on request parameters.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        })->when($filters['property_type_id'] ?? null, function (Builder $query, $typeId) {
            $query->where('property_type_id', $typeId);
        })->when($filters['city_id'] ?? null, function (Builder $query, $cityId) {
            $query->whereHas('area', function (Builder $query) use ($cityId) {
                $query->where('city_id', $cityId);
            });
        })->when($filters['area_id'] ?? null, function (Builder $query, $areaId) {
            $query->where('area_id', $areaId);
        })->when($filters['min_price'] ?? null, function (Builder $query, $minPrice) {
            $query->where('price', '>=', $minPrice);
        })->when($filters['max_price'] ?? null, function (Builder $query, $maxPrice) {
            $query->where('price', '<=', $maxPrice);
        })->when($filters['min_bedrooms'] ?? null, function (Builder $query, $minBedrooms) {
            $query->where('bedrooms', '>=', $minBedrooms);
        })->when($filters['max_bedrooms'] ?? null, function (Builder $query, $maxBedrooms) {
            $query->where('bedrooms', '<=', $maxBedrooms);
        })->when($filters['min_area_size'] ?? null, function (Builder $query, $minArea) {
            $query->where('area_size', '>=', $minArea);
        })->when($filters['max_area_size'] ?? null, function (Builder $query, $maxArea) {
            $query->where('area_size', '<=', $maxArea);
        })->when($filters['status'] ?? null, function (Builder $query, $status) {
            $query->where('status', $status);
        })->when($filters['is_furnished'] ?? null, function (Builder $query, $isFurnished) {
            $query->where('is_furnished', $isFurnished);
        })->when($filters['sort'] ?? null, function (Builder $query, $sort) {
            match ($sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                'oldest' => $query->orderBy('created_at', 'asc'),
                'area_size' => $query->orderBy('area_size', 'desc'),
                default => $query->latest(),
            };
        }, function (Builder $query) {
            $query->latest();
        });
    }

    /**
     * Get the user that owns the property.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the property type of the property.
     */
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    /**
     * Get the area that the property belongs to.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    /**
     * Get the features of the property.
     */
    public function features(): BelongsToMany
    {
        return $this->belongsToMany(PropertyFeature::class, 'property_feature_property');
    }

    /**
     * Get the images for the property.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }

    /**
     * Get the contact information for the property.
     */
    public function contacts(): HasMany
    {
        return $this->hasMany(PropertyContact::class);
    }

    /**
     * Get the main image of the property.
     */
    public function mainImage(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PropertyImage::class)->where('is_main', true);
    }

    /**
     * Accessor for the main image path.
     */
    public function getMainImagePathAttribute(): ?string
    {
        return $this->mainImage->image_path ?? $this->images()->first()?->image_path;
    }
}

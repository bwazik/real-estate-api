<?php

namespace App\Models;

use App\Enums\PropertyPurpose;
use App\Enums\PropertyStatus;
use Database\Factories\PropertyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

#[Fillable([
    'title',
    'slug',
    'description',
    'price',
    'purpose',
    'property_type_id',
    'area_id',
    'ad_date',
    'offer_type',
    'listing_status',
    'property_category',
    'offer_attribute',
    'offer_number',
    'property_name',
    'property_number',
    'property_area_text',
    'in_kind_registration',
    'platform_code',
    'plan_number',
    'deed_number',
    'deed_date',
    'deed_status',
    'facade_direction',
    'facades_count',
    'advertiser_name',
    'fal_license_number',
    'advertising_license_number',
    'property_address',
    'country',
    'city_name',
    'district_name',
    'street',
    'building_name',
    'floors_count',
    'apartment_number',
    'map_location',
    'units_and_facilities',
    'apartments_count',
    'living_rooms_count',
    'kitchens_count',
    'parking_spaces',
    'warehouses_count',
    'has_maids_room',
    'has_drivers_room',
    'entrances_count',
    'annexes_count',
    'income',
    'highest_bid',
    'brokerage_fee',
    'insurance_amount',
    'obligations',
    'advantages',
    'ad_information',
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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            if (empty($property->slug)) {
                $source = $property->property_name ?? $property->title ?? Str::random(8);
                $property->slug = Str::slug($source).'-'.Str::random(6);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'income' => 'decimal:2',
            'highest_bid' => 'decimal:2',
            'brokerage_fee' => 'decimal:2',
            'insurance_amount' => 'decimal:2',
            'bathrooms' => 'decimal:1',
            'area_size' => 'decimal:2',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
            'ad_date' => 'datetime',
            'deed_date' => 'date',
            'is_furnished' => 'boolean',
            'has_maids_room' => 'boolean',
            'has_drivers_room' => 'boolean',
            'bedrooms' => 'integer',
            'floor_number' => 'integer',
            'year_built' => 'integer',
            'views_count' => 'integer',
            'facades_count' => 'integer',
            'floors_count' => 'integer',
            'apartment_number' => 'integer',
            'apartments_count' => 'integer',
            'living_rooms_count' => 'integer',
            'kitchens_count' => 'integer',
            'parking_spaces' => 'integer',
            'warehouses_count' => 'integer',
            'entrances_count' => 'integer',
            'annexes_count' => 'integer',
            'purpose' => PropertyPurpose::class,
            'status' => PropertyStatus::class,
        ];
    }

    /**
     * Scope a query to only include available properties.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query->when($filters['search'] ?? null, function (Builder $query, $search) {
            $query->where(function (Builder $query) use ($search) {
                $query->where('property_name', 'like', "%{$search}%")
                    ->orWhere('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('city_name', 'like', "%{$search}%")
                    ->orWhere('district_name', 'like', "%{$search}%");
            });
        })->when($filters['offer_type'] ?? null, function (Builder $query, $offerType) {
            $query->where('offer_type', $offerType);
        })->when($filters['purpose'] ?? null, function (Builder $query, $purpose) {
            $query->where('purpose', $purpose);
        })->when($filters['listing_status'] ?? null, function (Builder $query, $listingStatus) {
            $query->where('listing_status', $listingStatus);
        })->when($filters['property_category'] ?? null, function (Builder $query, $propertyCategory) {
            $query->where('property_category', $propertyCategory);
        })->when($filters['property_type_slug'] ?? null, function (Builder $query, $typeSlug) {
            $query->whereHas('propertyType', function (Builder $query) use ($typeSlug) {
                $query->where('slug', $typeSlug);
            });
        })->when($filters['city_slug'] ?? null, function (Builder $query, $citySlug) {
            $query->whereHas('area.city', function (Builder $query) use ($citySlug) {
                $query->where('slug', $citySlug);
            });
        })->when($filters['area_slug'] ?? null, function (Builder $query, $areaSlug) {
            $query->whereHas('area', function (Builder $query) use ($areaSlug) {
                $query->where('slug', $areaSlug);
            });
        })->when($filters['city_name'] ?? null, function (Builder $query, $cityName) {
            $query->where('city_name', $cityName);
        })->when($filters['district_name'] ?? null, function (Builder $query, $districtName) {
            $query->where('district_name', $districtName);
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
        })->when($filters['is_furnished'] ?? null, function (Builder $query, $isFurnished) {
            $query->where('is_furnished', $isFurnished);
        })->when($filters['status'] ?? null, function (Builder $query, $status) {
            $query->where('status', $status);
        })->when($filters['offer_number'] ?? null, function (Builder $query, $offerNumber) {
            $query->where('offer_number', $offerNumber);
        })->when($filters['advertiser_name'] ?? null, function (Builder $query, $advertiserName) {
            $query->where('advertiser_name', 'like', "%{$advertiserName}%");
        })->when($filters['sort'] ?? null, function (Builder $query, $sort) {
            match ($sort) {
                'price_asc' => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest' => $query->orderBy('created_at', 'desc'),
                'oldest' => $query->orderBy('created_at', 'asc'),
                'area_size' => $query->orderBy('area_size', 'desc'),
                'ad_date_desc' => $query->orderBy('ad_date', 'desc'),
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

    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

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
    public function mainImage(): HasOne
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
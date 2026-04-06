<?php

namespace Database\Factories;

use App\Enums\PropertyPurpose;
use App\Enums\PropertyStatus;
use App\Models\Area;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $propertyName = 'عمارة للبيع '.fake()->city().' حي '.fake()->streetName();

        return [
            'title' => $propertyName,
            'slug' => Str::random(10) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => 'وصف تجريبي للعقار',
            'price' => fake()->randomFloat(2, 500000, 10000000),
            'purpose' => fake()->randomElement(PropertyPurpose::cases()),
            'property_type_id' => PropertyType::factory(),
            'area_id' => Area::factory(),
            'ad_date' => fake()->dateTimeBetween('-6 months', 'now'),
            'offer_type' => fake()->randomElement(['معروض', 'حصري']),
            'listing_status' => fake()->randomElement(['متاح', 'تم البيع', 'مؤجر']),
            'property_category' => fake()->randomElement(['سكنى', 'تجارى']),
            'offer_attribute' => fake()->randomElement(['بيع', 'إيجار']),
            'offer_number' => (string) fake()->unique()->numberBetween(1, 99999),
            'property_name' => $propertyName,
            'property_number' => (string) fake()->optional()->numberBetween(1, 9999),
            'property_area_text' => fake()->numberBetween(20, 60).'*'.fake()->numberBetween(100, 800),
            'in_kind_registration' => fake()->optional()->numerify('REG-#####'),
            'platform_code' => fake()->optional()->numerify('PLAT-#####'),
            'plan_number' => fake()->optional()->numerify('PLAN-####'),
            'deed_number' => fake()->optional()->numerify('DEED-######'),
            'deed_date' => fake()->optional()->date(),
            'deed_status' => fake()->randomElement(['ساري', 'منتهي', 'قيد المراجعة']),
            'facade_direction' => fake()->randomElement(['شمال', 'جنوب', 'شرق', 'غرب']),
            'facades_count' => fake()->numberBetween(0, 4),
            'advertiser_name' => fake()->company(),
            'fal_license_number' => fake()->numerify('##########'),
            'advertising_license_number' => fake()->numerify('###'),
            'property_address' => fake()->address(),
            'country' => 'السعودية',
            'city_name' => fake()->city(),
            'district_name' => fake()->streetName(),
            'street' => fake()->streetName(),
            'building_name' => fake()->randomElement(['كامل المبنى', 'جزء من المبنى']),
            'floors_count' => fake()->numberBetween(1, 10),
            'apartment_number' => fake()->numberBetween(1, 20),
            'map_location' => fake()->url(),
            'units_and_facilities' => fake()->sentence(),
            'apartments_count' => fake()->numberBetween(0, 20),
            'bedrooms' => fake()->numberBetween(1, 6),
            'living_rooms_count' => fake()->numberBetween(0, 6),
            'kitchens_count' => fake()->numberBetween(0, 6),
            'bathrooms' => fake()->randomFloat(1, 1, 4),
            'parking_spaces' => fake()->numberBetween(0, 5),
            'warehouses_count' => fake()->numberBetween(0, 3),
            'has_maids_room' => fake()->boolean(),
            'has_drivers_room' => fake()->boolean(),
            'entrances_count' => fake()->numberBetween(0, 4),
            'annexes_count' => fake()->numberBetween(0, 3),
            'area_size' => fake()->randomFloat(2, 50, 1000),
            'floor_number' => fake()->optional(0.7)->numberBetween(1, 20),
            'year_built' => fake()->optional(0.8)->year(),
            'is_furnished' => fake()->boolean(),
            'status' => fake()->randomElement(PropertyStatus::cases()),
            'latitude' => fake()->optional(0.9)->latitude(21.3, 24.0),
            'longitude' => fake()->optional(0.9)->longitude(39.0, 46.0),
            'income' => fake()->randomFloat(2, 0, 500000),
            'highest_bid' => fake()->randomFloat(2, 0, 500000),
            'brokerage_fee' => fake()->randomFloat(2, 0, 100000),
            'insurance_amount' => fake()->randomFloat(2, 0, 100000),
            'obligations' => fake()->optional()->sentence(),
            'advantages' => fake()->optional()->paragraph(),
            'ad_information' => fake()->optional()->paragraph(),
            'views_count' => fake()->numberBetween(0, 5000),
            'user_id' => User::factory(),
        ];
    }
}

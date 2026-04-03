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
        $adjectives = ['فاخر', 'راقي', 'مميز', 'مطل على النيل', 'بتشطيب سوبر لوكس', 'في موقع هادئ', 'موقع استراتيجي', 'واسع', 'حديث'];
        $nouns = ['شقة', 'فيلا', 'دوبلكس', 'مكتب', 'محل', 'شاليه'];
        
        $title = fake()->randomElement($nouns) . ' ' . fake()->randomElement($adjectives) . ' ' . fake()->numberBetween(100, 999);

        return [
            'title' => $title,
            'slug' => Str::random(10) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => 'هذا الوصف هو نص تجريبي لوصف العقار المختار. العقار يتميز بمواصفات عالية وتشطيبات فاخرة ويقع في منطقة مميزة جداً قريبة من كافة الخدمات.',
            'price' => fake()->randomFloat(2, 500000, 10000000),
            'purpose' => fake()->randomElement(PropertyPurpose::cases()),
            'property_type_id' => PropertyType::factory(),
            'area_id' => Area::factory(),
            'bedrooms' => fake()->numberBetween(1, 6),
            'bathrooms' => fake()->randomFloat(1, 1, 4),
            'area_size' => fake()->randomFloat(2, 50, 1000),
            'floor_number' => fake()->optional(0.7)->numberBetween(1, 20),
            'year_built' => fake()->optional(0.8)->year(),
            'is_furnished' => fake()->boolean(),
            'status' => fake()->randomElement(PropertyStatus::cases()),
            'latitude' => fake()->optional(0.9)->latitude(29.8, 30.2), // Localized around Cairo
            'longitude' => fake()->optional(0.9)->longitude(31.1, 31.5),
            'views_count' => fake()->numberBetween(0, 5000),
            'user_id' => User::factory(),
        ];
    }
}

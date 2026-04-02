<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        $title = fake()->sentence(4);

        return [
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->randomFloat(2, 50000, 5000000),
            'property_type_id' => \App\Models\PropertyType::factory(),
            'area_id' => \App\Models\Area::factory(),
            'bedrooms' => fake()->numberBetween(1, 6),
            'bathrooms' => fake()->randomFloat(1, 1, 4),
            'area_size' => fake()->randomFloat(2, 50, 1000),
            'floor_number' => fake()->optional(0.7)->numberBetween(1, 20),
            'year_built' => fake()->optional(0.8)->year(),
            'is_furnished' => fake()->boolean(),
            'status' => fake()->randomElement(['available', 'reserved', 'sold', 'rented', 'unavailable']),
            'latitude' => fake()->optional(0.9)->latitude(),
            'longitude' => fake()->optional(0.9)->longitude(),
            'views_count' => fake()->numberBetween(0, 1000),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}

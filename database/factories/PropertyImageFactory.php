<?php

namespace Database\Factories;

use App\Models\PropertyImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyImage>
 */
class PropertyImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'property_id' => \App\Models\Property::factory(),
            'image_path' => 'properties/' . fake()->uuid() . '.jpg',
            'is_main' => fake()->boolean(20),
            'order' => fake()->numberBetween(0, 5),
        ];
    }
}

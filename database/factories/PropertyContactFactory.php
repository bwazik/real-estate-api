<?php

namespace Database\Factories;

use App\Models\PropertyContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PropertyContact>
 */
class PropertyContactFactory extends Factory
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
            'phone' => fake()->phoneNumber(),
            'whatsapp' => fake()->optional(0.7)->phoneNumber(),
            'is_whatsapp' => fake()->boolean(70),
            'label' => fake()->randomElement(['Agent', 'Owner', 'Agency', 'Assistant']),
        ];
    }
}

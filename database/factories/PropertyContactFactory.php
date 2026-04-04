<?php

namespace Database\Factories;

use App\Models\Property;
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
        $phone = fake()->phoneNumber();
        return [
            'property_id' => Property::factory(),
            'phone' => $phone,
            'whatsapp' => $phone,
            'is_whatsapp' => true,
            'label' => fake()->randomElement(['Sales Agent', 'Owner', 'Office']),
        ];
    }
}

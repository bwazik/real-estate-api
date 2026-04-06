<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\PropertyContact;
use App\Models\PropertyFeature;
use App\Models\PropertyImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = PropertyFeature::all();
        $admin = User::where('is_admin', true)->first() ?? User::factory()->create(['is_admin' => true]);

        Property::factory()
            ->count(50)
            ->create(['user_id' => $admin->id])
            ->each(function (Property $property) use ($features) {
                // Attach random features
                $property->features()->attach(
                    $features->random(rand(3, 8))->pluck('id')->toArray()
                );

                // Add images
                PropertyImage::factory()->count(rand(3, 6))->create([
                    'property_id' => $property->id,
                ]);
                PropertyImage::query()
                    ->where('property_id', $property->id)
                    ->limit(1)
                    ->update(['is_main' => true]);

                // Add contacts
                PropertyContact::factory()->count(rand(1, 2))->create([
                    'property_id' => $property->id,
                ]);
            });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Property;
use App\Models\PropertyContact;
use App\Models\PropertyFeature;
use App\Models\PropertyImage;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $propertyTypes = PropertyType::all();
        $areas = Area::all();
        $features = PropertyFeature::all();
        $admin = User::where('is_admin', true)->first() ?? User::factory()->create(['is_admin' => true]);

        Property::factory()
            ->count(50)
            ->make()
            ->each(function ($property) use ($propertyTypes, $areas, $features, $admin) {
                $property->property_type_id = $propertyTypes->random()->id;
                $property->area_id = $areas->random()->id;
                $property->user_id = $admin->id;
                $property->save();

                // Attach random features
                $property->features()->attach(
                    $features->random(rand(3, 8))->pluck('id')->toArray()
                );

                // Add images
                PropertyImage::factory()->count(rand(3, 6))->create([
                    'property_id' => $property->id,
                ]);
                $property->images()->first()->update(['is_main' => true]);

                // Add contacts
                PropertyContact::factory()->count(rand(1, 2))->create([
                    'property_id' => $property->id,
                ]);
            });
    }
}

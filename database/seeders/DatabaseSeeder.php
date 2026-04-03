<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // Create Admin User
            User::factory()->create([
                'name' => 'Admin User',
                'email' => 'admin@flomax.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);

            // Call Seeders
            $this->call([
                PropertyTypeSeeder::class,
                CitySeeder::class,
                AreaSeeder::class,
                PropertyFeatureSeeder::class,
                PropertySeeder::class,
                SiteContentSeeder::class,
            ]);
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'شقة', 'description' => 'شقة سكنية'],
            ['name' => 'فيلا', 'description' => 'فيلا مستقلة'],
            ['name' => 'دوبلكس', 'description' => 'دوبلكس طابقين'],
            ['name' => 'بنتهاوس', 'description' => 'بنتهاوس علوي'],
            ['name' => 'تاون هاوس', 'description' => 'تاون هاوس متصل'],
            ['name' => 'مكتب', 'description' => 'مكتب إداري'],
            ['name' => 'محل', 'description' => 'محل تجاري'],
            ['name' => 'أرض', 'description' => 'أرض فضاء'],
            ['name' => 'شاليه', 'description' => 'شاليه مصيفي'],
            ['name' => 'استوديو', 'description' => 'استوديو صغير'],
        ];

        foreach ($types as $type) {
            PropertyType::create([
                'name' => $type['name'],
                'slug' => Str::slug($type['name']) ?: Str::random(10), // Str::slug might return empty for Arabic
                'description' => $type['description'],
            ]);
        }
    }
}

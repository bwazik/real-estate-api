<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'القاهرة' => ['المعادي', 'الزمالك', 'مدينة نصر', 'مصر الجديدة', 'جاردن سيتي'],
            'القاهرة الجديدة' => ['التجمع الخامس', 'التجمع الأول', 'القطامية'],
            'الجيزة' => ['الدقي', 'المهندسين', 'الشيخ زايد', 'الهرم'],
            'الإسكندرية' => ['ستانلي', 'سموحة', 'ميامي', 'العجمي'],
            '6 أكتوبر' => ['أشجار سيتي', 'دريم لاند', 'حدائق الأهرام'],
        ];

        foreach ($data as $cityName => $areas) {
            $city = City::where('name', $cityName)->first();
            if ($city) {
                foreach ($areas as $areaName) {
                    Area::create([
                        'city_id' => $city->id,
                        'name' => $areaName,
                        'slug' => Str::slug($areaName) ?: Str::random(10),
                    ]);
                }
            }
        }
    }
}

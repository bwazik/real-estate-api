<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = [
            ['name' => 'القاهرة', 'slug' => 'cairo'],
            ['name' => 'الإسكندرية', 'slug' => 'alexandria'],
            ['name' => 'الجيزة', 'slug' => 'giza'],
            ['name' => 'القاهرة الجديدة', 'slug' => 'new-cairo'],
            ['name' => '6 أكتوبر', 'slug' => '6-october'],
            ['name' => 'شرم الشيخ', 'slug' => 'sharm-el-sheikh'],
            ['name' => 'الغردقة', 'slug' => 'hurghada'],
            ['name' => 'المنصورة', 'slug' => 'mansoura'],
            ['name' => 'طنطا', 'slug' => 'tanta'],
        ];

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}

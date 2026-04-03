<?php

namespace Database\Seeders;

use App\Models\PropertyFeature;
use Illuminate\Database\Seeder;

class PropertyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            ['name' => 'حملم سباحة', 'icon' => 'pool'],
            ['name' => 'جراج', 'icon' => 'garage'],
            ['name' => 'مصعد', 'icon' => 'elevator'],
            ['name' => 'حديقة', 'icon' => 'garden'],
            ['name' => 'أمن 24/7', 'icon' => 'security'],
            ['name' => 'تكييف', 'icon' => 'ac'],
            ['name' => 'شرفة', 'icon' => 'balcony'],
            ['name' => 'مطبخ مجهز', 'icon' => 'kitchen'],
            ['name' => 'جيم', 'icon' => 'gym'],
            ['name' => 'إطلالة على البحر', 'icon' => 'sea'],
            ['name' => 'إطلالة على النيل', 'icon' => 'nile'],
            ['name' => 'إنترنت', 'icon' => 'internet'],
            ['name' => 'تدفئة مركزية', 'icon' => 'heating'],
            ['name' => 'غرفة خادمة', 'icon' => 'maid'],
            ['name' => 'مدخل خاص', 'icon' => 'entrance'],
            ['name' => 'سطح (رووف)', 'icon' => 'roof'],
        ];

        foreach ($features as $feature) {
            PropertyFeature::create($feature);
        }
    }
}

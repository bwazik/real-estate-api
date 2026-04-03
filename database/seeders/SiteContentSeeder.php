<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contents = [
            // Hero Section
            [
                'key' => 'hero_title',
                'value' => 'اكتشف منزل أحلامك',
                'type' => 'text',
                'group' => 'hero',
                'is_active' => true,
            ],
            [
                'key' => 'hero_subtitle',
                'value' => 'نحن نساعدك في العثور على المكان الأمثل للعيش والاستثمار',
                'type' => 'text',
                'group' => 'hero',
                'is_active' => true,
            ],
            [
                'key' => 'hero_button_text',
                'value' => 'تصفح العقارات',
                'type' => 'text',
                'group' => 'hero',
                'is_active' => true,
            ],

            // About Section
            [
                'key' => 'about_title',
                'value' => 'عن شركة فلوماكس',
                'type' => 'text',
                'group' => 'about',
                'is_active' => true,
            ],
            [
                'key' => 'about_description',
                'value' => 'نحن شركة فلوماكس رائدة في مجال التسويق العقاري حيث نقدم حلولاً متكاملة تجمع بين الفخامة المعمارية والقيمة الاستثمارية العالية. نحن نؤمن بأن العقار ليس مجرد جدران، بل هو بداية قصة نجاح وحياة جديدة.',
                'type' => 'rich_text',
                'group' => 'about',
                'is_active' => true,
            ],
            [
                'key' => 'team_button_text',
                'value' => 'تعرف على فريقنا',
                'type' => 'text',
                'group' => 'about',
                'is_active' => true,
            ],

            // About Features
            [
                'key' => 'feature_1',
                'value' => 'أفضل المواقع الاستراتيجية',
                'type' => 'text',
                'group' => 'about_features',
                'is_active' => true,
            ],
            [
                'key' => 'feature_2',
                'value' => 'تسهيلات في السداد والتمويل',
                'type' => 'text',
                'group' => 'about_features',
                'is_active' => true,
            ],
            [
                'key' => 'feature_3',
                'value' => 'دعم قانوني وفني متكامل',
                'type' => 'text',
                'group' => 'about_features',
                'is_active' => true,
            ],
            [
                'key' => 'feature_4',
                'value' => 'عقارات مسجلة وموثقة',
                'type' => 'text',
                'group' => 'about_features',
                'is_active' => true,
            ],
        ];

        foreach ($contents as $content) {
            SiteContent::updateOrCreate(['key' => $content['key']], $content);
        }
    }
}

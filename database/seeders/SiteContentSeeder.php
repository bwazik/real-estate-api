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
            [
                'key' => 'hero_slider',
                'value' => json_encode([
                    'hero-slider-1.jpg',
                    'hero-slider-2.jpg',
                    'hero-slider-3.jpg',
                    'hero-slider-4.jpg'
                ]),
                'type' => 'json',
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
                'key' => 'about_image',
                'value' => 'about-section-image.jpg',
                'type' => 'image',
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
            [
                'key' => 'about_features',
                'value' => json_encode([
                    ['title' => 'أفضل المواقع الاستراتيجية', 'icon' => 'feature-icon-1.png'],
                    ['title' => 'تسهيلات في السداد والتمويل', 'icon' => 'feature-icon-2.png'],
                    ['title' => 'دعم قانوني وفني متكامل', 'icon' => 'feature-icon-3.png'],
                    ['title' => 'عقارات مسجلة وموثقة', 'icon' => 'feature-icon-4.png'],
                ]),
                'type' => 'json',
                'group' => 'about',
                'is_active' => true,
            ],
        ];

        foreach ($contents as $content) {
            SiteContent::updateOrCreate(['key' => $content['key']], $content);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class SiteContent extends Model
{
    /** @use HasFactory<\Database\Factories\SiteContentFactory> */
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get content by key.
     */
    public static function getByKey(string $key, mixed $default = null): mixed
    {
        $content = self::where('key', $key)->where('is_active', true)->first();

        if (! $content) {
            return $default;
        }

        return $content->parseValue();
    }

    /**
     * Get all content for a specific group.
     */
    public static function getByGroup(string $group): Collection
    {
        return self::where('group', $group)
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(fn ($content) => [$content->key => $content->parseValue()]);
    }

    /**
     * Get structured Hero section content.
     */
    public static function getHeroContent(): array
    {
        $hero = self::getByGroup('hero');

        $sliderImages = collect($hero->get('hero_slider', []))->map(function ($image) {
            return asset('storage/site/' . $image);
        })->all();

        return [
            'title' => $hero->get('hero_title'),
            'subtitle' => $hero->get('hero_subtitle'),
            'button_text' => $hero->get('hero_button_text'),
            'slider_images' => $sliderImages,
        ];
    }

    /**
     * Get structured About section content.
     */
    public static function getAboutContent(): array
    {
        $about = self::getByGroup('about');

        return [
            'title' => $about->get('about_title'),
            'description' => $about->get('about_description'),
            'image_url' => $about->get('about_image') 
                ? asset('storage/site/' . $about->get('about_image')) 
                : null,
            'team_button_text' => $about->get('team_button_text'),
            'features' => $about->get('about_features', []),
        ];
    }

    /**
     * Store single image.
     */
    public static function storeImage(string $key, UploadedFile $file): string
    {
        $path = $file->store('site', 'public');
        return basename($path);
    }

    /**
     * Store multiple images.
     */
    public static function storeMultipleImages(string $key, array $files): array
    {
        return array_map(fn ($file) => self::storeImage($key, $file), $files);
    }

    /**
     * Parse the value based on its type.
     */
    public function parseValue(): mixed
    {
        if ($this->type === 'json') {
            return json_decode($this->value, true);
        }

        return $this->value;
    }
}

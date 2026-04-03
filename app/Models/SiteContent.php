<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
     * Get Hero section content.
     */
    public static function getHeroContent(): Collection
    {
        return self::getByGroup('hero');
    }

    /**
     * Get About section content.
     */
    public static function getAboutContent(): Collection
    {
        return self::getByGroup('about');
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

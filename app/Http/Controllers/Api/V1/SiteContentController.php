<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UpdateSiteContentRequest;
use App\Models\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class SiteContentController extends BaseApiController
{
    /**
     * Get all content for a specific group.
     */
    public function getByGroup(string $group): JsonResponse
    {
        $cache = Cache::supportsTags() ? Cache::tags(['static_data', 'site_content']) : Cache::getFacadeRoot();

        $content = $cache->remember("site_content_{$group}", 3600, function () use ($group) {
            if ($group === 'hero') return SiteContent::getHeroContent();
            if ($group === 'about') return SiteContent::getAboutContent();
            return SiteContent::getByGroup($group);
        });

        return $this->successResponse($content);
    }

    /**
     * Update site content (text or image).
     *
     * Example 1: Upload Hero Slider (Multipart/Form-Data)
     * key: "hero_slider"
     * files[]: [file1, file2]
     *
     * Example 2: Upload About Image (Multipart/Form-Data)
     * key: "about_image"
     * file: [image_file]
     *
     * Example 3: Update Text (Multipart/Form-Data or JSON)
     * key: "hero_title"
     * value: "نص جديد"
     *
     * @param UpdateSiteContentRequest $request
     * @return JsonResponse
     */
    public function update(UpdateSiteContentRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $content = SiteContent::where('key', $validated['key'])->firstOrFail();

        // 1. Determine the new value (file, files, or raw text value)
        $newValue = $validated['value'] ?? $content->value;

        if ($request->hasFile('file')) {
            $newValue = SiteContent::storeImage($content->key, $request->file('file'));
        } elseif ($request->hasFile('files')) {
            $newValue = json_encode(SiteContent::storeMultipleImages($content->key, $request->file('files')));
        }

        // 2. Perform the update
        $content->update(['value' => $newValue]);

        // 3. Clear cache
        Cache::tags(['site_content'])->flush();

        // 4. Return refreshed structured content
        $result = $this->getRefreshedContent($content->group);

        return $this->successResponse($result, 'تم التحديث بنجاح');
    }

    /**
     * Helper to get refreshed data based on affected group.
     */
    private function getRefreshedContent(string $group): array|object
    {
        return match ($group) {
            'hero' => SiteContent::getHeroContent(),
            'about' => SiteContent::getAboutContent(),
            default => SiteContent::getByGroup($group),
        };
    }
}

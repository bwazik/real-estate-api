<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\UpdateSiteContentRequest;
use App\Models\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SiteContentController extends BaseApiController
{
    /**
     * Get all content for a specific group.
     */
    public function getByGroup(string $group): JsonResponse
    {
        $cache = Cache::supportsTags() ? Cache::tags(['static_data', 'site_content']) : Cache::getFacadeRoot();

        $content = $cache->remember("site_content_{$group}", 3600, function () use ($group) {
            return SiteContent::getByGroup($group);
        });

        return $this->successResponse($content);
    }

    /**
     * Update multiple contents at once.
     */
    public function update(UpdateSiteContentRequest $request): JsonResponse
    {
        $validated = $request->validated();

        try {
            DB::transaction(function () use ($validated) {
                foreach ($validated['contents'] as $item) {
                    SiteContent::where('key', $item['key'])->update([
                        'value' => is_array($item['value']) ? json_encode($item['value']) : $item['value'],
                    ]);
                }
            });

            if (Cache::supportsTags()) {
                Cache::tags(['site_content'])->flush();
            }

            return $this->successResponse(null, 'Site content updated successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to update site content', 500, $e->getMessage());
        }
    }
}

<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\Frontend\Resources\CompanyProfileResource;
use App\Models\CompanyProfile;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;

class CompanyProfileController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $profiles = Cache::remember('company_profiles_all', 600, function () {
            return CompanyProfile::query()
                ->select(['section_key','headline', 'title', 'summary', 'body', 'featured_image_url', 'cta_label', 'cta_link'])
                ->orderBy('section_key')
                ->get();
        });

        return CompanyProfileResource::collection($profiles)
            ->additional([
                'meta' => [
                    'version' => '1.0',
                    'generated_at' => now()->toISOString(),
                ],
            ]);
    }
}

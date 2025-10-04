<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeamMember;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\API\Frontend\Resources\CompanyTeamMemberResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CompanyTeamMemberController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $members = Cache::remember(
            key: 'company_team_members_all',
            ttl: now()->addMinutes(10), 
            callback: function () {
                return CompanyTeamMember::select([
                        'id',
                        'full_name',
                        'job_title',
                        'department',
                        'location',
                        'profile_image_url',
                        'rating',
                        'review_count',
                        'social_links',
                        'is_featured',
                        'display_order'
                    ])
                    ->ordered()
                    ->get();
            }
        );

        return CompanyTeamMemberResource::collection($members)->additional([
            'meta' => [
                'version'      => '1.0',
                'generated_at' => now()->toIsoString(),
            ],
        ]);
    }
}

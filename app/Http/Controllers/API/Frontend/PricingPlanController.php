<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PricingPlan;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\API\Frontend\Resources\PricingPlanResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PricingPlanController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $pricing = Cache::remember(
            key: 'pricing_plan',
            ttl: now()->addMinutes(10),
            callback: function () {
                return PricingPlan::select([
                    'slug',
                    'name',
                    'short_description',
                    'is_public',
                    'sort_order',
                ])
                    ->get();
            }
        );

        return PricingPlanResource::collection($pricing)->additional([
            'meta' => [
                'version' => '1.0',
                'generated_at' => now()->toIsoString(),
            ],
        ]);
    }
}

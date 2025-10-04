<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\Controller;
use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\API\Frontend\Resources\WhyChooseUsResource;

class WhyChooseUsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $data = Cache::remember('why_choose_us_all', 600, function () {
            return WhyChooseUs::query()
                ->select(['section_title', 'section_subtitle', 'item_title', 'item_description'])
                ->orderBy('item_title')
                ->get();
        });
        return WhyChooseUsResource::collection($data)
            ->additional([
                'meta' => [
                    'version' => '1.0',
                    'generated_at' => now()->toISOString(),
                ],
            ]);
    }

}

<?php

namespace App\Http\Resources\API\Frontend\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PricingPlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'short_description' => $this->short_description ?? '',
            'is_public' => (bool) $this->is_public,
            'sort_order' => (int) $this->sort_order,

            // // Nếu bạn có quan hệ "planPrices" thì có thể trả kèm theo:
            // 'prices' => $this->whenLoaded('prices', function () {
            //     return $this->prices->map(function ($price) {
            //         return [
            //             'currency' => $price->currency,
            //             'amount' => (float) $price->amount,
            //             'billing_period' => $price->billing_period,
            //             'trial_days' => (int) $price->trial_days,
            //         ];
            //     });
            // }),

            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}

<?php

namespace App\Http\Resources\API\Frontend\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyTeamMemberResource extends JsonResource
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
            'full_name' => $this->full_name,
            'job_title' => $this->job_title,
            'department' => $this->department,
            'location' => $this->location,

            // trả về URL đầy đủ cho ảnh hoặc ảnh mặc định
            'profile_image_url' => $this->profile_image_url
                ? asset($this->profile_image_url)
                : asset('uploads/no_image.jpg'),

            'rating' => isset($this->rating) ? (int) $this->rating : null,
            'review_count' => isset($this->review_count) ? (int) $this->review_count : 0,
            'social_links' => $this->social_links ?? [],
            'is_featured' => (bool) $this->is_featured,
            'display_order' => isset($this->display_order) ? (int) $this->display_order : 0,
        ];
    }
}
 
<?php

namespace App\Http\Resources\API\Frontend\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'section_key' => $this->section_key,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'featured_image_url' => $this->featured_image_url,
            'cta' => [
                'label' => $this->cta_label,
                'link' => $this->cta_link,
            ],
        ];
    }
}

<?php

namespace App\Http\Resources\API\Frontend\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WhyChooseUsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'section_title' => $this->section_title,
            'section_subtitle'=> $this->section_subtitle,
            'item_title' => $this->item_title,
            'item_description' => $this->item_description,
        ];
    }
}

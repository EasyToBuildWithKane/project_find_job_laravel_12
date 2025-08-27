<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    protected $table = 'company_profiles';

    protected $fillable = [
        'section_key',
        'headline',
        'title',
        'summary',
        'body',
        'featured_image_url',
        'cta_label',
        'cta_link',
    ];

    protected $casts = [
        'body' => 'string',
    ];

    /**
     * Scope để lấy section theo key (ví dụ: about, mission, vision)
     */
    public function scopeSection($query, string $key)
    {
        return $query->where('section_key', $key);
    }
}

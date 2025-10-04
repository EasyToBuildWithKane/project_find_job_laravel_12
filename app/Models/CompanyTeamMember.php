<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTeamMember extends Model
{
    protected $table = 'company_team_members';

    protected $fillable = [
        'full_name',
        'job_title',
        'department',
        'location',
        'profile_image_url',
        'rating',
        'review_count',
        'social_links',
        'is_featured',
        'display_order',
    ];

    protected $casts = [
        'social_links'  => 'array',
        'is_featured'   => 'boolean',
        'rating'        => 'integer',
        'review_count'  => 'integer',
    ];

    /**
     * Scope: chỉ lấy những thành viên nổi bật (featured).
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope: sắp xếp theo thứ tự hiển thị.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}

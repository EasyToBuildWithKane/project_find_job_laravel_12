<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'user_id', 'name', 'slug', 'industry_type_id', 'organization_type_id',
        'team_size_id', 'logo', 'banner', 'establishment_date', 'website',
        'phone', 'email', 'bio', 'vision', 'total_views', 'address',
        'city', 'state', 'country', 'map_link', 'is_profile_verified',
        'document_verified_at', 'profile_completion', 'visibility'
    ];

    // Relations
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function industryType() {
        return $this->belongsTo(IndustryType::class, 'industry_type_id');
    }

    public function organizationType() {
        return $this->belongsTo(OrganizationType::class, 'organization_type_id');
    }

    public function teamSize() {
        return $this->belongsTo(TeamSize::class, 'team_size_id');
    }

    public function cityRel() {
        return $this->belongsTo(City::class, 'city');
    }

    public function stateRel() {
        return $this->belongsTo(State::class, 'state');
    }

    public function countryRel() {
        return $this->belongsTo(Country::class, 'country');
    }
}

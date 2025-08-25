<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInformation extends Model
{
    use HasFactory;

    protected $table = 'user_information';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'full_name',
        'dob',
        'gender',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'postal_code',
        'country_code',
        'timezone',
        'language',
        'avatar_url',
        'cover_image_url',
        'kyc_status',
        'kyc_submitted_at',
        'kyc_verified_by',
        'referral_code',
        'referred_by',
        'marketing_opt_in',
        'privacy_policy_accepted_at',
        'terms_accepted_at',
        'last_password_change_at',
    ];

    protected $casts = [
        'dob' => 'date',
        'kyc_submitted_at' => 'datetime',
        'marketing_opt_in' => 'boolean',
        'privacy_policy_accepted_at' => 'datetime',
        'terms_accepted_at' => 'datetime',
        'last_password_change_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kycVerifier()
    {
        return $this->belongsTo(User::class, 'kyc_verified_by');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasUuids;

  
    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'first_name',
        'last_name',
        'full_name',
        'dob',
        'gender',
        'address_line',
        'link_social',
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
    ];

    
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'last_failed_login_at' => 'datetime',
        'kyc_submitted_at' => 'datetime',
        'marketing_opt_in' => 'boolean',
        'two_factor_enabled' => 'boolean',
    ];

   
    public function kycVerifier()
    {
        return $this->belongsTo(User::class, 'kyc_verified_by');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    public function otps()
    {
        return $this->hasMany(OtpCode::class);
    }
}

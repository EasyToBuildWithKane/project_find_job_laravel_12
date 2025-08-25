<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'uuid',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'email_verified_at',
        'phone_verified_at',
        'last_login_ip',
        'last_login_at',
        'two_factor_enabled',
        'two_factor_secret',
        'failed_login_attempts',
        'last_failed_login_at',
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
        'two_factor_enabled' => 'boolean',
        'failed_login_attempts' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($user) {
            if (empty($user->uuid)) {
                $user->uuid = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    // Relationships
    public function userInformation()
    {
        return $this->hasOne(UserInformation::class);
    }

    public function otps()
    {
        return $this->hasMany(OtpCode::class);
    }
}

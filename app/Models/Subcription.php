<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcription extends Model
{
    protected $table = 'subscriptions';

    protected $casts = [
        'meta' => 'array',
        'started_at' => 'datetime',
        'trial_ends_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    protected $fillable = [
        'user_id',
        'plan_id',
        'price_id',
        'status',
        'started_at',
        'trial_ends_at',
        'ends_at',
        'external_subscription_id',
        'meta',
    ];

    public function plan()
    {
        return $this->belongsTo(PricingPlan::class, 'plan_id');
    }

    public function price()
    {
        return $this->belongsTo(PlanPrice::class, 'price_id');
    }
}

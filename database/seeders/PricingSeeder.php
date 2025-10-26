<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PricingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // pricing_plans
        DB::table('pricing_plans')->insert([
            [
                'slug' => 'basic',
                'name' => 'Cơ bản',
                'short_description' => 'Phù hợp cho cá nhân, giới hạn tính năng',
                'is_public' => 1,
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'pro',
                'name' => 'Pro',
                'short_description' => 'Gói Pro cho nhà tuyển dụng nhỏ',
                'is_public' => 1,
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'slug' => 'enterprise',
                'name' => 'Doanh nghiệp',
                'short_description' => 'Gói Doanh nghiệp: không giới hạn & SLA',
                'is_public' => 1,
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // plan_prices (VND monthly)
        $basicId = DB::table('pricing_plans')->where('slug','basic')->value('id');
        $proId   = DB::table('pricing_plans')->where('slug','pro')->value('id');
        $entId   = DB::table('pricing_plans')->where('slug','enterprise')->value('id');

        DB::table('plan_prices')->insert([
            [
                'plan_id' => $basicId,
                'currency' => 'VND',
                'amount' => 0.00,
                'billing_period' => 'monthly',
                'trial_days' => 0,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'plan_id' => $proId,
                'currency' => 'VND',
                'amount' => 500000.00,
                'billing_period' => 'monthly',
                'trial_days' => 14,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'plan_id' => $entId,
                'currency' => 'VND',
                'amount' => 2500000.00,
                'billing_period' => 'monthly',
                'trial_days' => 14,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        // Example subscription (you must ensure user with id=2 exists in users table)
        $proPriceId = DB::table('plan_prices')->where('plan_id', $proId)->where('billing_period', 'monthly')->value('id');

        DB::table('subscriptions')->insert([
            'user_id' => 2,
            'plan_id' => $proId,
            'price_id' => $proPriceId,
            'status' => 'trial',
            'started_at' => $now,
            'trial_ends_at' => $now->copy()->addDays(14),
            'ends_at' => $now->copy()->addMonth(),
            'external_subscription_id' => 'stripe_sub_example_001',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}

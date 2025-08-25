<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\OtpCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class OtpCodeFactory extends Factory
{
    protected $model = OtpCode::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'otp' => (string) rand(100000, 999999),
            'context' => $this->faker->randomElement(['login', 'register', 'password_reset']),
            'delivery_method' => $this->faker->randomElement(['email', 'sms']),
            'attempts' => 0,
            'expires_at' => now()->addMinutes(5),
            'is_used' => false,
            'sent_to_ip' => $this->faker->ipv4(),
        ];
    }
}

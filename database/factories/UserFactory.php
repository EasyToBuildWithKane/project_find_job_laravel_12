<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'uuid' => $this->faker->uuid(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->userName() . '@gmail.com',
            'phone' => '0' . $this->faker->numerify('9########'),
            'password' => Hash::make('password'),
            'role' => $this->faker->randomElement(['freelancer', 'employer']),
            'status' => 'active',

            'email_verified_at' => now(),
            'phone_verified_at' => $this->faker->optional()->dateTime(),

            'last_login_ip' => $this->faker->ipv4(),
            'last_login_at' => $this->faker->dateTimeBetween('-1 month', 'now'),

            'two_factor_enabled' => false,
            'two_factor_secret' => null,

            'failed_login_attempts' => 0,
            'last_failed_login_at' => null,
            'remember_token' => Str::random(10),
        ];
    }
}

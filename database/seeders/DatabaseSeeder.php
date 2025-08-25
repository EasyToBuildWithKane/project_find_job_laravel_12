<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserInformation;
use App\Models\OtpCode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()
            ->count(20)
            ->has(UserInformation::factory())
            ->create();

        OtpCode::factory()
            ->count(5)
            ->create();

        User::factory()
            ->has(UserInformation::factory([
                'first_name' => 'Khoa',
                'last_name' => 'Nguyễn',
                'full_name' => 'Admin',
                'city' => 'Sài Gòn',
                'state' => 'Sài Gòn',
            ]))
            ->create([
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'phone' => '0935769312',
                'role' => 'admin',
                'password' => bcrypt('password'),
            ]);
    }
}

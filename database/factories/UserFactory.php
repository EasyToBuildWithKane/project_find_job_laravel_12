<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $users = [
            [
                'username' => 'admin_master',
                'email' => 'admin@gmail.com',
                'phone' => '0909123456',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'first_name' => 'Quản',
                'last_name' => 'Trị',
                'full_name' => 'Quản Trị Viên',
                'gender' => 'male',
                'dob' => '1990-01-01',
                'city' => 'Hà Nội',
                'country_code' => 'VN',
                'language' => 'vi',
                'timezone' => 'Asia/Ho_Chi_Minh',
                'avatar_url' => '/images/users/admin.png',
                'marketing_opt_in' => true,
                'privacy_policy_accepted_at' => $now,
                'terms_accepted_at' => $now,
                'last_password_change_at' => $now,
            ],
            [
                'username' => 'freelancer_hung',
                'email' => 'hung.freelancer@gmail.com',
                'phone' => '0909555123',
                'password' => Hash::make('password'),
                'role' => 'freelancer',
                'status' => 'active',
                'first_name' => 'Hùng',
                'last_name' => 'Nguyễn',
                'full_name' => 'Nguyễn Văn Hùng',
                'gender' => 'male',
                'dob' => '1995-04-15',
                'city' => 'Hồ Chí Minh',
                'country_code' => 'VN',
                'language' => 'vi',
                'timezone' => 'Asia/Ho_Chi_Minh',
                'avatar_url' => '/images/users/hung.png',
                'marketing_opt_in' => false,
                'privacy_policy_accepted_at' => $now,
                'terms_accepted_at' => $now,
            ],
            [
                'username' => 'employer_anhthu',
                'email' => 'anhthu.employer@gmail.com',
                'phone' => '0912345678',
                'password' => Hash::make('password'),
                'role' => 'employer',
                'status' => 'active',
                'first_name' => 'Anh',
                'last_name' => 'Thư',
                'full_name' => 'Lê Anh Thư',
                'gender' => 'female',
                'dob' => '1988-12-05',
                'city' => 'Đà Nẵng',
                'country_code' => 'VN',
                'language' => 'vi',
                'timezone' => 'Asia/Ho_Chi_Minh',
                'avatar_url' => '/images/users/anhthu.png',
                'marketing_opt_in' => true,
                'privacy_policy_accepted_at' => $now,
                'terms_accepted_at' => $now,
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['username' => $data['username']],
                $data
            );
        }
    }
}

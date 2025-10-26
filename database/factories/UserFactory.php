<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        $firstNames = ['Nguyen', 'Tran', 'Le', 'Pham', 'Hoang', 'Dang', 'Bui', 'Do', 'Vu', 'Ngo'];
        $lastNames = ['An', 'Binh', 'Cuong', 'Dung', 'Hanh', 'Hieu', 'Khanh', 'Lan', 'Linh', 'Minh', 'Nam', 'Ngoc', 'Phong', 'Quang', 'Son', 'Thao', 'Trang', 'Tuan', 'Vy'];

        $firstName = $this->faker->randomElement($firstNames);
        $lastName = $this->faker->randomElement($lastNames);
        $fullName = trim("{$firstName} {$lastName}");

        // Tạo username dạng slug, đảm bảo unique
        $username = Str::slug($fullName) . $this->faker->unique()->numberBetween(10, 9999);

        return [
            // ==== Thông tin tài khoản ====
            'username' => $username,
            'email' => $username . '@gmail.com',
            'phone' => $this->faker->unique()->numerify(
                $this->faker->randomElement(['03########', '05########', '07########', '08########', '09########'])
            ),
            'password' => Hash::make('123456'),
            'role' => $this->faker->randomElement(['freelancer', 'employer', 'admin']),
            'status' => 'active',

            // ==== Xác thực ====
            'email_verified_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'phone_verified_at' => $this->faker->optional(0.6)->dateTimeBetween('-1 year', 'now'),

            // ==== Lần đăng nhập gần nhất ====
            'last_login_ip' => $this->faker->ipv4(),
            'last_login_at' => $this->faker->optional()->dateTimeBetween('-30 days', 'now'),

            // ==== Bảo mật ====
            'two_factor_enabled' => false,
            'two_factor_secret' => null,
            'failed_login_attempts' => $this->faker->numberBetween(0, 3),
            'last_failed_login_at' => $this->faker->optional()->dateTimeBetween('-10 days', 'now'),

            // ==== Thông tin cá nhân ====
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'dob' => $this->faker->dateTimeBetween('-45 years', '-18 years')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),

            // ==== Địa chỉ ====
            'address_line' => $this->faker->streetAddress(),
            'link_social' => $this->faker->optional(0.4)->url(),
            'city' => $this->faker->city(),
            'postal_code' => $this->faker->postcode(),
            'country_code' => 'VN',

            // ==== Hệ thống ====
            'timezone' => 'Asia/Ho_Chi_Minh',
            'language' => 'vi',

            // ==== Hình ảnh ====
            'avatar_url' => $this->faker->imageUrl(200, 200, 'people', true, $fullName),
            'cover_image_url' => $this->faker->imageUrl(800, 300, 'nature', true, 'Cover'),

            // ==== Mặc định ====
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Người dùng đã xác minh.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ]);
    }

    /**
     * Người dùng bị khóa.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
        ]);
    }

    /**
     * Người dùng bị xóa (soft delete).
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'deleted_at' => now(),
            'status' => 'deleted',
        ]);
    }
}

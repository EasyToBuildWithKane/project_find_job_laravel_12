<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        // Danh sách tên Việt Nam
        $firstNames = ['Nguyen', 'Tran', 'Le', 'Pham', 'Hoang', 'Dang', 'Bui', 'Do', 'Vu', 'Ngo'];
        $lastNames = ['An', 'Binh', 'Cuong', 'Dung', 'Hanh', 'Hieu', 'Khanh', 'Lan', 'Linh', 'Minh', 'Nam', 'Ngoc', 'Phong', 'Quang', 'Son', 'Thao', 'Trang', 'Tuan', 'Vy'];

        $firstName = $this->faker->randomElement($firstNames);
        $lastName = $this->faker->randomElement($lastNames);
        $fullName = $firstName . ' ' . $lastName;

        // Email @gmail.com
        $email = Str::slug($fullName, '') . $this->faker->numberBetween(100, 999) . '@gmail.com';

        // SĐT Việt Nam
        $prefixes = ['03', '05', '07', '08', '09'];
        $phone = $this->faker->randomElement($prefixes) . $this->faker->numerify('########');

        return [
            'id' => $this->faker->randomNumber(9),

            'username' => Str::lower(Str::slug($fullName, '')) . $this->faker->numberBetween(1, 999),
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make('123456'), // mật khẩu mặc định
            'role' => $this->faker->randomElement(['freelancer', 'employer']),
            'status' => 'active',

            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'dob' => $this->faker->dateTimeBetween('-40 years', '-18 years')->format('Y-m-d'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'city' => $this->faker->city,
            'country_code' => 'VN',
            'language' => 'vi',
        ];
    }
}

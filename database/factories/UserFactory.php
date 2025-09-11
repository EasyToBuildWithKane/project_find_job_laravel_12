<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $firstNames = ['Nguyen', 'Tran', 'Le', 'Pham', 'Hoang', 'Dang', 'Bui', 'Do', 'Vu', 'Ngo'];
        $lastNames = ['An', 'Binh', 'Cuong', 'Dung', 'Hanh', 'Hieu', 'Khanh', 'Lan', 'Linh', 'Minh', 'Nam', 'Ngoc', 'Phong', 'Quang', 'Son', 'Thao', 'Trang', 'Tuan', 'Vy'];

        $firstName = $this->faker->randomElement($firstNames);
        $lastName = $this->faker->randomElement($lastNames);
        $fullName = "$firstName $lastName";

        return [
            'username' => Str::lower(Str::slug($fullName)) . $this->faker->unique()->numberBetween(1, 999),
            'email' => Str::lower(Str::slug($fullName)) . $this->faker->unique()->numberBetween(100, 999) . '@gmail.com',
            'phone' => $this->faker->randomElement(['03', '05', '07', '08', '09']) . $this->faker->numerify('########'),
            'password' => Hash::make('123456'),
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

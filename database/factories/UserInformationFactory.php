<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserInformationFactory extends Factory
{
    protected $model = UserInformation::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'user_id' => User::factory(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $firstName . ' ' . $lastName,
            'dob' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),

            'address_line1' => $this->faker->streetAddress(),
            'address_line2' => $this->faker->optional()->randomElement([
                'Tầng ' . $this->faker->numberBetween(1, 9),
                'Hẻm ' . $this->faker->numberBetween(1, 300),
                'Block ' . $this->faker->randomLetter(),
            ]),
            'city' => $this->faker->city(),
            'state' => $this->faker->randomElement(['Hà Nội', 'Hồ Chí Minh', 'Đà Nẵng', 'Hải Phòng', 'Cần Thơ']),
            'postal_code' => $this->faker->postcode(),
            'country_code' => 'VN',

            'timezone' => 'Asia/Ho_Chi_Minh',
            'language' => 'vi',

            'avatar_url' => $this->faker->imageUrl(200, 200, 'people', true),
            'cover_image_url' => $this->faker->optional()->imageUrl(1200, 300, 'abstract', true),

            'kyc_status' => $this->faker->randomElement(['pending', 'verified', 'rejected']),
            'kyc_submitted_at' => $this->faker->optional()->dateTimeBetween('-2 months', 'now'),
            'kyc_verified_by' => null,

            'referral_code' => strtoupper($this->faker->bothify('REF###')),
            'referred_by' => null,

            'marketing_opt_in' => $this->faker->boolean(30),
            'privacy_policy_accepted_at' => now(),
            'terms_accepted_at' => now(),
            'last_password_change_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
    }
}

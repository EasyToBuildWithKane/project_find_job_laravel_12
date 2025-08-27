<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyTeamMember;

class CompanyTeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'full_name' => 'Nguyễn Văn An',
                'job_title' => 'Giám Đốc Điều Hành',
                'department' => 'Ban Lãnh Đạo',
                'location' => 'Hà Nội, Việt Nam',
                'profile_image_url' => 'https://via.placeholder.com/400x400.png?text=Nguyen+Van+An',
                'rating' => 5,
                'review_count' => 45,
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/nguyenvanan',
                    'facebook' => 'https://facebook.com/nguyenvanan'
                ]),
                'is_featured' => true,
                'display_order' => 1,
            ],
            [
                'full_name' => 'Trần Thị Bích',
                'job_title' => 'Giám Đốc Công Nghệ',
                'department' => 'Phát Triển Sản Phẩm',
                'location' => 'TP. Hồ Chí Minh, Việt Nam',
                'profile_image_url' => 'https://via.placeholder.com/400x400.png?text=Tran+Thi+Bich',
                'rating' => 5,
                'review_count' => 38,
                'social_links' => json_encode([
                    'linkedin' => 'https://linkedin.com/in/tranthibich',
                ]),
                'is_featured' => true,
                'display_order' => 2,
            ],
            [
                'full_name' => 'Lê Hoàng Nam',
                'job_title' => 'Trưởng Phòng Kinh Doanh',
                'department' => 'Kinh Doanh',
                'location' => 'Đà Nẵng, Việt Nam',
                'profile_image_url' => 'https://via.placeholder.com/400x400.png?text=Le+Hoang+Nam',
                'rating' => 4,
                'review_count' => 25,
                'social_links' => json_encode([
                    'facebook' => 'https://facebook.com/lehoangnam'
                ]),
                'is_featured' => false,
                'display_order' => 3,
            ],
        ];

        foreach ($members as $member) {
            CompanyTeamMember::create($member);
        }
    }
}

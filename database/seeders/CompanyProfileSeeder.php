<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CompanyProfile;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'section_key' => 'about',
                'headline' => 'Về Chúng Tôi',
                'title' => 'Mang Giá Trị Thực Sự Cho Doanh Nghiệp Việt',
                'summary' => 'Chúng tôi tiên phong trong việc cung cấp giải pháp công nghệ tối ưu, giúp doanh nghiệp phát triển bền vững.',
                'body' => '<p>Được thành lập từ năm 2015, công ty chúng tôi chuyên cung cấp dịch vụ phát triển phần mềm, tư vấn chuyển đổi số và giải pháp quản lý thông minh. Với đội ngũ kỹ sư dày dạn kinh nghiệm, chúng tôi cam kết mang đến các sản phẩm chất lượng cao, dễ mở rộng và tiết kiệm chi phí vận hành.</p>',
                'featured_image_url' => 'https://via.placeholder.com/1200x600.png?text=About+Us',
                'cta_label' => 'Tìm Hiểu Thêm',
                'cta_link' => '/about',
            ],
            [
                'section_key' => 'vision',
                'headline' => 'Tầm Nhìn',
                'title' => 'Trở Thành Đơn Vị Dẫn Đầu Khu Vực Đông Nam Á',
                'summary' => 'Không ngừng đổi mới để kiến tạo giá trị lâu dài.',
                'body' => '<p>Chúng tôi hướng tới việc trở thành đối tác chiến lược trong lĩnh vực công nghệ cho hàng nghìn doanh nghiệp khu vực Đông Nam Á vào năm 2030.</p>',
                'featured_image_url' => 'https://via.placeholder.com/1200x600.png?text=Vision',
                'cta_label' => 'Khám Phá Tầm Nhìn',
                'cta_link' => '/vision',
            ],
            [
                'section_key' => 'mission',
                'headline' => 'Sứ Mệnh',
                'title' => 'Giúp Doanh Nghiệp Chuyển Đổi Số Toàn Diện',
                'summary' => 'Chúng tôi đồng hành cùng doanh nghiệp trong mọi bước phát triển.',
                'body' => '<p>Sứ mệnh của chúng tôi là xây dựng các giải pháp công nghệ thông minh, dễ sử dụng, và tối ưu chi phí để mọi doanh nghiệp đều có thể tiếp cận chuyển đổi số một cách hiệu quả.</p>',
                'featured_image_url' => 'https://via.placeholder.com/1200x600.png?text=Mission',
                'cta_label' => 'Khám Phá Sứ Mệnh',
                'cta_link' => '/mission',
            ],
        ];

        foreach ($profiles as $profile) {
            CompanyProfile::create($profile);
        }
    }
}

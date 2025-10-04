<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WhyChooseUsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('why_choose_us')->insert([
            [
                'section_title'     => 'Why choose us',
                'section_subtitle'  => 'Lý do khách hàng chọn chúng tôi',
                'item_title'        => 'Đội ngũ chuyên nghiệp',
                'item_description'  => 'Chúng tôi có đội ngũ nhân viên giàu kinh nghiệm và nhiệt huyết.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'section_title'     => 'Why choose us',
                'section_subtitle'  => 'Lý do khách hàng chọn chúng tôi',
                'item_title'        => 'Dịch vụ tận tâm',
                'item_description'  => 'Luôn lắng nghe và hỗ trợ khách hàng 24/7.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'section_title'     => 'Why choose us',
                'section_subtitle'  => 'Lý do khách hàng chọn chúng tôi',
                'item_title'        => 'Giải pháp tối ưu',
                'item_description'  => 'Đưa ra các giải pháp phù hợp nhất cho từng nhu cầu.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'section_title'     => 'Why choose us',
                'section_subtitle'  => 'Lý do khách hàng chọn chúng tôi',
                'item_title'        => 'Giá cả cạnh tranh',
                'item_description'  => 'Mang đến giá trị tốt nhất với chi phí hợp lý.',
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ]);
    }
}

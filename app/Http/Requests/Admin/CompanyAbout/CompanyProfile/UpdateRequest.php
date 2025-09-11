<?php

namespace App\Http\Requests\Admin\CompanyAbout\CompanyProfile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $profileId = $this->route('company_profile');

        return [
            'section_key' => [
                'required',
                'string',
                'max:100',
                "unique:company_profiles,section_key,{$profileId},id"
            ],
            'title' => 'required|string|max:255',
            'headline' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'body' => 'nullable|string',
            'featured_image_url' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:2048', // 2MB
            'cta_label' => 'nullable|string|max:50',
            'cta_link' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'section_key.required' => 'Hãy nhập Section Key. Đây là khóa định danh duy nhất, giúp hệ thống phân biệt các phần nội dung. Chúng tôi khuyến nghị dùng ký tự không dấu, không khoảng trắng.',
            'section_key.unique' => 'Section Key này đã tồn tại. Vui lòng nhập một giá trị khác để tránh xung đột dữ liệu.',
            'section_key.max' => 'Section Key quá dài. Vui lòng dùng tối đa 100 ký tự.',

            'title.required' => 'Tiêu đề là bắt buộc. Tiêu đề hấp dẫn giúp người đọc nhanh hiểu nội dung phần này.',
            'title.max' => 'Tiêu đề quá dài, vui lòng nhập tối đa 255 ký tự.',

            'headline.max' => 'Headline quá dài, vui lòng nhập tối đa 255 ký tự.',
            'summary.max' => 'Summary quá dài, hãy tóm tắt trong 1000 ký tự để người đọc dễ tiếp nhận.',
            
            'featured_image_url.image' => 'Ảnh tải lên không hợp lệ. Chỉ chấp nhận định dạng JPEG, PNG, GIF hoặc WEBP.',
            'featured_image_url.mimes' => 'Chỉ chấp nhận các định dạng ảnh: jpeg, jpg, png, gif, webp.',
            'featured_image_url.max' => 'Ảnh quá lớn. Vui lòng tải lên ảnh dưới 2MB để đảm bảo hiệu năng.',

            'body.string' => 'Nội dung chi tiết phải là văn bản hợp lệ.',
            'cta_label.max' => 'Nhãn nút CTA quá dài, tối đa 50 ký tự.',
            'cta_link.url' => 'Liên kết CTA phải là một URL hợp lệ, ví dụ: https://example.com',
            'cta_link.max' => 'Liên kết CTA quá dài, tối đa 255 ký tự.',
        ];
    }
}

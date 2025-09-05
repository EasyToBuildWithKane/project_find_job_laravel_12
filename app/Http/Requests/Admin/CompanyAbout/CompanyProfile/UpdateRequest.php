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
        return [
            // Bỏ unique vì section_key lấy từ route, không từ form
            'headline' => 'nullable|string|max:150',
            'title' => 'required|string|max:200',
            'summary' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'featured_image_url' => 'nullable|url|max:255',
            'cta_label' => 'nullable|string|max:100',
            'cta_link' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề chính.',
            'title.string' => 'Tiêu đề chính phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề chính không được vượt quá :max ký tự.',
            'headline.max' => 'Tiêu đề phụ không được vượt quá :max ký tự.',
            'summary.max' => 'Tóm tắt không được vượt quá :max ký tự.',
            'featured_image_url.url' => 'URL ảnh nổi bật không hợp lệ.',
            'cta_link.url' => 'Liên kết kêu gọi không hợp lệ.',
        ];
    }
}

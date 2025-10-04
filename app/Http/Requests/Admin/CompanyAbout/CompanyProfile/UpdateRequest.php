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
            'headline' => 'nullable|string|max:150',
            'title' => 'required|string|max:200',
            'summary' => 'nullable|string|max:500',
            'body' => 'nullable|string',
            'featured_image_url' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:2048',
            ],
            'cta_label' => 'nullable|string|max:100',

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
            'featured_image_url.image' => 'Ảnh đại diện phải là một hình ảnh hợp lệ.',
            'featured_image_url.mimes' => 'Ảnh đại diện chỉ được phép có định dạng: jpg, jpeg, png, webp, gif.',
            'featured_image_url.max' => 'Ảnh đại diện không được vượt quá 2MB.',
        ];
    }
}
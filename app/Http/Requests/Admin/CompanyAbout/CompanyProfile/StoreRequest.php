<?php

namespace App\Http\Requests\Admin\CompanyProfile;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'section_key' => 'required|string|max:100|unique:company_profiles,section_key',
            'headline' => 'nullable|string|max:150',
            'title' => 'required|string|max:200',
            'summary' => 'nullable|string|max:500',
            'body' => 'nullable|string', // cho phép HTML/Markdown
            'featured_image_url' => 'nullable|url|max:255',
            'cta_label' => 'nullable|string|max:100',
            'cta_link' => 'nullable|url|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'section_key.required' => 'Vui lòng nhập khóa mục (section key).',
            'section_key.string' => 'Khóa mục phải là chuỗi ký tự.',
            'section_key.max' => 'Khóa mục không được vượt quá :max ký tự.',
            'section_key.unique' => 'Khóa mục này đã tồn tại, vui lòng chọn khóa khác.',

            'headline.string' => 'Tiêu đề phụ phải là chuỗi ký tự.',
            'headline.max' => 'Tiêu đề phụ không được vượt quá :max ký tự.',

            'title.required' => 'Vui lòng nhập tiêu đề chính.',
            'title.string' => 'Tiêu đề chính phải là chuỗi ký tự.',
            'title.max' => 'Tiêu đề chính không được vượt quá :max ký tự.',

            'summary.string' => 'Tóm tắt phải là chuỗi ký tự.',
            'summary.max' => 'Tóm tắt không được vượt quá :max ký tự.',

            'body.string' => 'Nội dung phải là chuỗi ký tự.',

            'featured_image_url.url' => 'URL ảnh nổi bật không hợp lệ.',
            'featured_image_url.max' => 'URL ảnh nổi bật không được vượt quá :max ký tự.',

            'cta_label.string' => 'Nhãn nút kêu gọi (CTA) phải là chuỗi ký tự.',
            'cta_label.max' => 'Nhãn nút kêu gọi không được vượt quá :max ký tự.',

            'cta_link.url' => 'Liên kết kêu gọi (CTA link) không hợp lệ.',
            'cta_link.max' => 'Liên kết kêu gọi không được vượt quá :max ký tự.',
        ];
    }

}

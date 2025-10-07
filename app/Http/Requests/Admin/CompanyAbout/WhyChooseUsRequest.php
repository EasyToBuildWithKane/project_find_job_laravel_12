<?php

namespace App\Http\Requests\Admin\CompanyAbout;

use Illuminate\Foundation\Http\FormRequest;

class WhyChooseUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Cho phép tất cả
    }

    public function rules(): array
    {
        return [
            'section_title' => 'nullable|string|max:255',
            'section_subtitle' => 'nullable|string|max:255',
            'item_title' => 'required|string|max:255',
            'item_description' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
    
            'item_title.required'=> 'Tiêu đề item là bắt buộc.',
            'item_title.max'     => 'Tiêu đề item không được vượt quá 255 ký tự.',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin\OtpCode;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'is_used' => ['sometimes', 'boolean'],
            'used_at' => ['sometimes', 'nullable', 'date', 'before_or_equal:now'],
            'attempts' => ['sometimes', 'integer', 'min:0', 'max:10'],
            'expires_at' => ['sometimes', 'date', 'after:now'],
        ];
    }

    public function messages(): array
    {
        return [
            'is_used.boolean' => 'Trạng thái sử dụng phải là true/false.',
            'used_at.date' => 'Thời gian sử dụng không hợp lệ.',
            'used_at.before_or_equal' => 'Thời gian sử dụng không được vượt quá hiện tại.',
            'attempts.integer' => 'Số lần nhập phải là số nguyên.',
            'attempts.max' => 'Số lần nhập không được vượt quá 10.',
            'expires_at.after' => 'Thời gian hết hạn mới phải nằm trong tương lai.',
        ];
    }
}

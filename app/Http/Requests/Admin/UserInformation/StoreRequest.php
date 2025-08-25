<?php

namespace App\Http\Requests\Admin\UserInformation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Để Admin có quyền thực hiện
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer', 'exists:users,id', 'unique:user_information,user_id'],
            'first_name' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-]+$/u'],
            'last_name' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\s\'\-]+$/u'],
            'full_name' => ['nullable', 'string', 'min:2', 'max:200'],
            'dob' => ['nullable', 'date', 'before:' . now()->subYears(13)->toDateString()],
            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],
            'address_line1' => ['nullable', 'string', 'min:5', 'max:150'],
            'address_line2' => ['nullable', 'string', 'min:3', 'max:150'],
            'city' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s\-]+$/u'],
            'state' => ['nullable', 'string', 'min:2', 'max:100', 'regex:/^[\p{L}\p{N}\s\-]+$/u'],
            'postal_code' => ['nullable', 'string', 'max:20', 'regex:/^[\p{L}\p{N}\-\s]+$/u'],
            'country_code' => ['nullable', 'string', 'min:2', 'max:10'],
            'timezone' => ['nullable', 'string', Rule::in(timezone_identifiers_list())],
            'language' => ['nullable', 'string', 'min:2', 'max:10', 'regex:/^[a-z]+$/'],
            'avatar_url' => ['nullable', 'url', 'max:255'],
            'cover_image_url' => ['nullable', 'url', 'max:255'],
            'kyc_status' => ['nullable', Rule::in(['pending', 'verified', 'rejected'])],
            'kyc_verified_by' => ['nullable', 'integer', 'exists:users,id'],
            'referral_code' => ['nullable', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/'],
            'referred_by' => ['nullable', 'integer', 'exists:users,id'],
            'marketing_opt_in' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Người dùng là bắt buộc.',
            'user_id.unique' => 'Thông tin người dùng này đã tồn tại.',
            'first_name.regex' => 'Tên chỉ được chứa chữ, khoảng trắng, dấu nháy hoặc gạch nối.',
            'dob.before' => 'Ngày sinh phải trước ' . now()->subYears(13)->format('d/m/Y') . ' (tối thiểu 13 tuổi).',
            'timezone.in' => 'Múi giờ không hợp lệ.',
            'language.regex' => 'Ngôn ngữ chỉ được chứa chữ cái thường (ví dụ: en, vi).',
            'avatar_url.url' => 'Avatar phải là URL hợp lệ.',
        ];
    }
}

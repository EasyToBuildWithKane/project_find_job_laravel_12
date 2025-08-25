<?php

namespace App\Http\Requests\Admin\OtpCode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'user_id' => ['nullable', 'exists:users,id'],
            'otp' => ['required', 'string', 'regex:/^[0-9A-Za-z]{4,10}$/'],
            'context' => ['required', 'string', 'max:50', Rule::in(['register', 'password_reset', '2fa', 'transaction'])],
            'delivery_method' => ['required', Rule::in(['email', 'sms', 'push'])],
            'expires_at' => ['required', 'date', 'after:now'],
            'sent_to_ip' => ['nullable', 'ip'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.exists' => 'Người dùng không tồn tại.',
            'otp.required' => 'Vui lòng nhập mã OTP.',
            'otp.regex' => 'OTP chỉ gồm 4–10 ký tự chữ hoặc số.',
            'context.required' => 'Bối cảnh OTP là bắt buộc.',
            'context.in' => 'Bối cảnh không hợp lệ.',
            'delivery_method.required' => 'Phương thức gửi OTP là bắt buộc.',
            'delivery_method.in' => 'Phương thức gửi OTP không được hỗ trợ.',
            'expires_at.after' => 'Thời gian hết hạn phải nằm trong tương lai.',
            'sent_to_ip.ip' => 'Địa chỉ IP không hợp lệ.',
        ];
    }
}

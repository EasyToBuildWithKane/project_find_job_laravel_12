<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'min:4',
                'max:100',
                'regex:/^[a-zA-Z0-9_.-]+$/',
                'unique:users,username',
            ],
            'email' => [
                'nullable',
                'string',
                'email:rfc,dns',
                'max:150',
                'unique:users,email',
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^(0|\+84)([0-9]{9})$/',
                'unique:users,phone',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).+$/',
            ],
            'role' => [
                'required',
                Rule::in(['freelancer', 'employer', 'admin']),
            ],
            'status' => [
                'nullable',
                Rule::in(['active', 'suspended', 'deleted']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Tên đăng nhập không được bỏ trống.',
            'username.min' => 'Tên đăng nhập phải có ít nhất :min ký tự.',
            'username.max' => 'Tên đăng nhập không vượt quá :max ký tự.',
            'username.regex' => 'Tên đăng nhập chỉ được chứa chữ, số, dấu gạch dưới, gạch ngang, dấu chấm.',
            'username.unique' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.',

            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không vượt quá :max ký tự.',
            'email.unique' => 'Email đã được sử dụng.',

            'phone.regex' => 'Số điện thoại phải theo định dạng Việt Nam (0xxxxxxxxx hoặc +84xxxxxxxxx).',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không vượt quá :max ký tự.',
            'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',

            'role.in' => 'Vai trò không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}

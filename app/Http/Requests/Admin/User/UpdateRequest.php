<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $userId = $this->route('user'); 

        return [
            'username' => [
                'sometimes',
                'string',
                'min:4',
                'max:100',
                'regex:/^[a-zA-Z0-9_.-]+$/',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'email' => [
                'nullable',
                'string',
                'email:rfc,dns',
                'max:150',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => [
                'nullable',
                'string',
                'regex:/^(0|\+84)([0-9]{9})$/',
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'max:64',
                'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).+$/',
            ],
            'role' => [
                'sometimes',
                Rule::in(['freelancer', 'employer', 'admin']),
            ],
            'status' => [
                'sometimes',
                Rule::in(['active', 'suspended', 'deleted']),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.min' => 'Tên đăng nhập phải có ít nhất :min ký tự.',
            'username.max' => 'Tên đăng nhập không vượt quá :max ký tự.',
            'username.regex' => 'Tên đăng nhập chỉ được chứa chữ, số, dấu gạch dưới, gạch ngang, dấu chấm.',
            'username.unique' => 'Tên đăng nhập đã tồn tại, vui lòng chọn tên khác.',

            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không vượt quá :max ký tự.',
            'email.unique' => 'Email đã được sử dụng.',

            'phone.regex' => 'Số điện thoại phải theo định dạng Việt Nam (0xxxxxxxxx hoặc +84xxxxxxxxx).',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',

            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
            'password.max' => 'Mật khẩu không vượt quá :max ký tự.',
            'password.regex' => 'Mật khẩu phải có ít nhất 1 chữ hoa, 1 chữ thường, 1 số và 1 ký tự đặc biệt.',

            'role.in' => 'Vai trò không hợp lệ.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}

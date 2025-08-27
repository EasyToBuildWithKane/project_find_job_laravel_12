<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $userId = Auth::id();
        $minDate = Carbon::now()->subYears(110)->toDateString(); // Giới hạn 110 năm trước

        return [
            'username' => [
                'required',
                'string',
                'min:4',
                'max:50',
                'not_regex:/[@#$%]|^[\w\.\-]+@([\w\-]+\.)+[\w\-]{2,4}$/',
                Rule::unique('users', 'username')->ignore($userId),
            ],
            'first_name' => ['nullable', 'string', 'max:30'],
            'last_name'  => ['nullable', 'string', 'max:30'],
            'phone'      => ['nullable', 'regex:/^(0|\+84)[0-9]{9}$/'],
            'link_social'=> ['nullable', 'url', 'max:255'],
            'avatar_url' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // Giới tính: chỉ nhận male/female/other
            'gender'     => ['nullable', Rule::in(['male', 'female', 'other'])],

            // Ngày sinh: hợp lệ, <= hôm nay, >= 110 năm trước
            'dob' => [
                'nullable',
                'date',
                'before_or_equal:today',
                "after_or_equal:$minDate",
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'username.required'  => 'Vui lòng nhập tên người dùng.',
            'username.min'       => 'Tên người dùng phải có ít nhất 4 ký tự.',
            'username.max'       => 'Tên người dùng không được vượt quá 50 ký tự.',
            'username.unique'    => 'Tên người dùng này đã tồn tại.',
            'username.not_regex' => 'Tên người dùng không được chứa ký tự đặc biệt hoặc ở dạng email.',

            'first_name.max' => 'Họ không được vượt quá 30 ký tự.',
            'last_name.max'  => 'Tên không được vượt quá 30 ký tự.',

            'phone.regex'    => 'Số điện thoại không hợp lệ (phải theo định dạng Việt Nam).',

            'link_social.url' => 'Liên kết mạng xã hội phải là một URL hợp lệ.',
            'link_social.max' => 'Liên kết mạng xã hội không được vượt quá 255 ký tự.',

            'avatar_url.image' => 'Ảnh đại diện phải là một hình ảnh.',
            'avatar_url.mimes' => 'Ảnh đại diện chỉ được phép có định dạng: jpg, jpeg, png.',
            'avatar_url.max'   => 'Ảnh đại diện không được vượt quá 2MB.',

            'gender.in' => 'Giới tính không hợp lệ. Chỉ chấp nhận: male, female, other.',

            'dob.date'             => 'Ngày sinh phải là một ngày hợp lệ.',
            'dob.before_or_equal'  => 'Ngày sinh không thể ở tương lai.',
            'dob.after_or_equal'   => 'Tuổi của bạn không được vượt quá 110 năm.',
        ];
    }
}

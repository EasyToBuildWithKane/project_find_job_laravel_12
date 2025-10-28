<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class JobExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('job_experience'); // lấy ID khi update
        return [
            'name' => 'required|string|max:255|unique:job_experiences,name,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên kinh nghiệm.',
            'name.unique'   => 'Tên này đã tồn tại.',
        ];
    }
}

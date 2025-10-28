<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class JobRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('job_role'); // Lấy ID khi update
        return [
            'name' => 'required|string|max:255|unique:job_roles,name,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên vị trí.',
            'name.unique'   => 'Tên vị trí đã tồn tại.',
        ];
    }
}

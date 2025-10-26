<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class SkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:skills,name,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên kỹ năng là bắt buộc.',
            'name.unique' => 'Tên kỹ năng đã tồn tại.',
        ];
    }
}







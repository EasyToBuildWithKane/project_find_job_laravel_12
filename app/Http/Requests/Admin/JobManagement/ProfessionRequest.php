<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class ProfessionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:professions,name,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên nghề nghiệp là bắt buộc.',
            'name.unique' => 'Tên nghề nghiệp đã tồn tại.',
        ];
    }
}







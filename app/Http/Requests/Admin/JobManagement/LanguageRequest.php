<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:languages,name,' . $id,
            'code' => 'required|string|max:10|unique:languages,code,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên ngôn ngữ là bắt buộc.',
            'name.unique' => 'Tên ngôn ngữ đã tồn tại.',
            'code.required' => 'Mã ngôn ngữ là bắt buộc.',
            'code.unique' => 'Mã ngôn ngữ đã tồn tại.',
        ];
    }
}







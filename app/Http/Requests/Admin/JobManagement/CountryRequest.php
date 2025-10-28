<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:countries,name,' . $id,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên quốc gia là bắt buộc.',
            'name.string' => 'Tên quốc gia phải là chuỗi ký tự hợp lệ.',
            'name.max' => 'Tên quốc gia không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên quốc gia này đã tồn tại trong hệ thống.',
        ];
    }
}







<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class EducationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('education'); // Lấy ID khi update
        return [
            'name' => 'required|string|max:255|unique:education,name,' . $id,
        ];
    }
}

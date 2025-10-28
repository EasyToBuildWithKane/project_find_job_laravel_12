<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class JobTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:job_types,name,' . $this->route('job_type'),
        ];
    }
}

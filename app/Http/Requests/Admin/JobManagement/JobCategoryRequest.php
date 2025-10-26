<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class JobCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->route('job_category');
        return [
            'name' => 'required|string|max:255|unique:job_categories,name,' . $id,
            'icon' => 'nullable|string|max:255',
            'show_at_popular' => 'nullable|boolean',
            'show_at_featured' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique'   => 'Tên danh mục đã tồn tại.',
        ];
    }
}

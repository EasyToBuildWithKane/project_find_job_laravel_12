<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $jobId = $this->route('job');
        return [
            'company_id' => 'required|exists:companies,id',
            'job_category_id' => 'required|exists:job_categories,id',
            'job_role_id' => 'required|exists:job_roles,id',
            'job_experience_id' => 'required|exists:job_experiences,id',
            'education_id' => 'required|exists:education,id',
            'job_type_id' => 'required|exists:job_types,id',
            'salary_type_id' => 'required|exists:salary_types,id',
            'title' => 'required|string|max:255|unique:jobs,title,' . $jobId,
            'vacancies' => 'required|string|max:50',
            'min_salary' => 'nullable|numeric',
            'max_salary' => 'nullable|numeric|gte:min_salary',
            'custom_salary' => 'nullable|string|max:255',
            'deadline' => 'required|date|after_or_equal:today',
            'description' => 'required|string',
            'status' => 'required|in:pending,active,expired',
            'apply_on' => 'required|in:app,email,custom_url',
            'apply_email' => 'nullable|email|required_if:apply_on,email',
            'apply_url' => 'nullable|url|required_if:apply_on,custom_url',
            'featured' => 'nullable|boolean',
            'highlight' => 'nullable|boolean',
            'featured_until' => 'nullable|date|after_or_equal:today',
            'highlight_until' => 'nullable|date|after_or_equal:today',
            'city_id' => 'nullable|exists:cities,id',
            'state_id' => 'nullable|exists:states,id',
            'country_id' => 'nullable|exists:countries,id',
            'address' => 'nullable|string|max:255',
            'salary_mode' => 'required|in:range,custom',
            'company_name' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Tiêu đề công việc không được để trống',
            'title.unique' => 'Tiêu đề công việc đã tồn tại',
            'company_id.required' => 'Chọn công ty',
            'job_category_id.required' => 'Chọn danh mục công việc',
            'job_role_id.required' => 'Chọn vị trí công việc',
            'job_experience_id.required' => 'Chọn kinh nghiệm',
            'education_id.required' => 'Chọn trình độ',
            'job_type_id.required' => 'Chọn loại công việc',
            'salary_type_id.required' => 'Chọn loại lương',
            'deadline.after_or_equal' => 'Hạn nộp phải từ hôm nay trở đi',
        ];
    }
}

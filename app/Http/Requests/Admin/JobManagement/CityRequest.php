<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('id');

        return [
            'name' => 'required|string|max:255|unique:cities,name,' . $id,
            'state_id' => 'required|exists:states,id',
            'country_id' => 'required|exists:countries,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên thành phố là bắt buộc.',
            'name.unique' => 'Tên thành phố đã tồn tại.',
            'state_id.required' => 'Vui lòng chọn tỉnh/bang.',
            'state_id.exists' => 'Tỉnh/bang không hợp lệ.',
            'country_id.required' => 'Vui lòng chọn quốc gia.',
            'country_id.exists' => 'Quốc gia không hợp lệ.',
        ];
    }
}




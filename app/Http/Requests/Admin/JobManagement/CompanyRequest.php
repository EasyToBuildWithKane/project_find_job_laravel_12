<?php

namespace App\Http\Requests\Admin\JobManagement;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Chỉ định quyền truy cập, true để tất cả admin có thể
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'establishment_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'vision' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'industry_type_id' => 'nullable|exists:industry_types,id',
            'organization_type_id' => 'nullable|exists:organization_types,id',
            'team_size_id' => 'nullable|exists:team_sizes,id',
            'city' => 'nullable|exists:cities,id',
            'state' => 'nullable|exists:states,id',
            'country' => 'nullable|exists:countries,id',
            'map_link' => 'nullable|url',
            'is_profile_verified' => 'nullable|boolean',
            'document_verified_at' => 'nullable|date',
            'profile_completion' => 'nullable|boolean',
            'visibility' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên công ty là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'website.url' => 'Website không hợp lệ.',
            'logo.image' => 'Logo phải là file hình ảnh.',
            'banner.image' => 'Banner phải là file hình ảnh.',
            'user_id.required' => 'Người dùng quản lý công ty là bắt buộc.',
        ];
    }
}

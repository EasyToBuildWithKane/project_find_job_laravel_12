<?php

namespace App\Http\Requests\Admin\CompanyAbout\CompanyTeamMember;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Vui lòng nhập họ và tên.',
            'full_name.string' => 'Họ và tên phải là chuỗi ký tự.',
            'full_name.max' => 'Họ và tên không được vượt quá :max ký tự.',

            'job_title.required' => 'Vui lòng nhập chức danh.',
            'job_title.string' => 'Chức danh phải là chuỗi ký tự.',
            'job_title.max' => 'Chức danh không được vượt quá :max ký tự.',

            'department.string' => 'Phòng ban phải là chuỗi ký tự.',
            'department.max' => 'Phòng ban không được vượt quá :max ký tự.',

            'location.string' => 'Địa điểm phải là chuỗi ký tự.',
            'location.max' => 'Địa điểm không được vượt quá :max ký tự.',

            'profile_image_url.url' => 'URL ảnh đại diện không hợp lệ.',
            'profile_image_url.max' => 'URL ảnh đại diện không được vượt quá :max ký tự.',

            'rating.integer' => 'Đánh giá phải là số nguyên.',
            'rating.min' => 'Đánh giá tối thiểu là :min.',
            'rating.max' => 'Đánh giá tối đa là :max.',

            'review_count.integer' => 'Số lượt đánh giá phải là số nguyên.',
            'review_count.min' => 'Số lượt đánh giá không được nhỏ hơn :min.',

            'social_links.array' => 'Liên kết mạng xã hội phải là mảng.',
            'social_links.*.url' => 'Mỗi liên kết mạng xã hội phải là URL hợp lệ.',

            'is_featured.boolean' => 'Trạng thái nổi bật phải là true hoặc false.',

            'display_order.integer' => 'Thứ tự hiển thị phải là số nguyên.',
            'display_order.min' => 'Thứ tự hiển thị không được nhỏ hơn :min.',
        ];
    }

}

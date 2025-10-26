<?php

namespace App\Http\Requests\Admin\Pricing\PricingPlan;

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
     * Validation rules for creating a pricing plan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'slug' => 'required|string|max:100|unique:pricing_plans,slug',
            'name' => 'required|string|max:150',
            'short_description' => 'nullable|string|max:255',
            'is_public' => 'nullable|boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'slug.required' => 'Vui lòng nhập mã định danh gói (slug).',
            'slug.string' => 'Slug phải là chuỗi ký tự.',
            'slug.max' => 'Slug không được vượt quá :max ký tự.',
            'slug.unique' => 'Slug này đã tồn tại, vui lòng chọn slug khác.',

            'name.required' => 'Vui lòng nhập tên gói.',
            'name.string' => 'Tên gói phải là chuỗi ký tự.',
            'name.max' => 'Tên gói không được vượt quá :max ký tự.',

            'short_description.string' => 'Mô tả ngắn phải là chuỗi ký tự.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá :max ký tự.',

            'is_public.boolean' => 'Trạng thái hiển thị phải là kiểu đúng/sai (boolean).',

            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn :min.',
        ];
    }
}

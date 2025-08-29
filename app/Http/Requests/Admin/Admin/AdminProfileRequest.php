<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Chuẩn hoá một số input trước khi validate:
     * - trim các field
     * - username -> lowercase + trim
     * - chuẩn hoá phone (loại bỏ ký tự không phải số, convert sang 0xxxxxxxxx hoặc +84xxxxxxxxx khi có thể)
     * - nếu link_social thiếu scheme thì thêm https://
     */
    protected function prepareForValidation(): void
    {
        $input = $this->all();

        // Trim tất cả string inputs cơ bản
        foreach (['username', 'first_name', 'last_name', 'phone', 'link_social', 'dob'] as $k) {
            if ($this->has($k) && is_string($this->input($k))) {
                $input[$k] = trim($this->input($k));
            }
        }

        // username: lowercase (giúp check uniqueness nhất quán)
        if (!empty($input['username'])) {
            $input['username'] = mb_strtolower($input['username']);
        }

        // phone: remove non-digit, normalize
        if (!empty($input['phone'])) {
            $digits = preg_replace('/\D+/', '', $input['phone']);
            // nếu bắt đầu bằng 84 và đúng 11 chữ số -> +84XXXXXXXXX
            if (preg_match('/^84\d{9}$/', $digits)) {
                $input['phone'] = '+'.$digits;
            }
            // nếu đúng 10 chữ số và bắt đầu bằng 0 -> giữ 0XXXXXXXXX
            elseif (preg_match('/^0\d{9}$/', $digits)) {
                $input['phone'] = $digits;
            }
            // nếu đúng 9 chữ số -> thêm 0
            elseif (preg_match('/^\d{9}$/', $digits)) {
                $input['phone'] = '0'.$digits;
            } else {
                // fallback: giữ nguyên (let validator xử lý)
                $input['phone'] = $this->input('phone');
            }
        }

        // link_social: thêm https nếu người dùng quên
        if (!empty($input['link_social'])) {
            if (!preg_match('/^https?:\/\//i', $input['link_social'])) {
                $input['link_social'] = 'https://' . $input['link_social'];
            }
        }

        $this->merge($input);
    }

    public function rules(): array
    {
        $userId = Auth::id();

        // tuổi tối đa 110 năm trước, tối thiểu 13 tuổi
        $oldestDate = Carbon::now()->subYears(110)->toDateString();
        $youngestDate = Carbon::now()->subYears(13)->toDateString();

        return [
            'username' => [
                'required',
                'string',
                'min:4',
                'max:50',
                // Không cho phép hoàn toàn là số
                'not_regex:/^\d+$/',
                // Username cho phép chữ (unicode), số, dot, underscore, hyphen
                // Không bắt đầu/ket thúc bằng dot/underscore/hyphen, không cho phép 2 ký tự đặc biệt liên tiếp
                'regex:/^(?!.*[._-]{2})[\p{L}\p{N}](?:[\p{L}\p{N}._-]{2,48})[\p{L}\p{N}]$/u',
                // Không cho các tên reserved
                Rule::notIn(['admin','administrator','root','system','support','superadmin','staff','user','null']),
                // unique username (ignore current user)
                Rule::unique('users', 'username')->ignore($userId),
            ],

            // Tên: Unicode letters + dấu, khoảng trắng, dấu chấm, apostrophe, hyphen
            'first_name' => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\p{M}\'\-\s\.]+$/u'],
            'last_name'  => ['nullable', 'string', 'max:30', 'regex:/^[\p{L}\p{M}\'\-\s\.]+$/u'],

            // Phone: optional, nếu có phải là 0xxxxxxxxx hoặc +84xxxxxxxxx
            'phone' => [
                'nullable',
                'string',
                'max:20',
                'regex:/^(0|\+84)\d{9}$/',
                Rule::unique('users', 'phone')->ignore($userId),
            ],

            // Social link: url, length giới hạn. (Sau prepareForValidation sẽ có https nếu thiếu)
            'link_social' => ['nullable', 'string', 'url', 'max:255'],

            // Avatar: image, cho phép webp,gif,jpg,png; kích thước <= 2MB; thêm giới hạn dimensions
            'avatar_url' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp,gif',
                'max:2048', // KB -> 2MB
                'dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            ],

            'gender' => ['nullable', Rule::in(['male', 'female', 'other'])],

            // Ngày sinh: hợp lệ, tuổi từ 13 -> 110
            'dob' => [
                'nullable',
                'date',
                "after_or_equal:{$oldestDate}",
                "before_or_equal:{$youngestDate}",
            ],
        ];
    }

    public function messages(): array
    {
        return [
            // username
            'username.required'  => 'Vui lòng nhập tên người dùng.',
            'username.min'       => 'Tên người dùng phải có ít nhất 4 ký tự.',
            'username.max'       => 'Tên người dùng không được vượt quá 50 ký tự.',
            'username.unique'    => 'Tên người dùng này đã tồn tại.',
            'username.not_regex' => 'Tên người dùng không được chỉ là số.',
            'username.regex'     => 'Tên người dùng không hợp lệ. Chỉ chấp nhận chữ, số, ".", "_" hoặc "-" và không được bắt đầu/kết thúc bằng ký tự đặc biệt, hoặc lặp ký tự đặc biệt liên tiếp.',

            // first/last
            'first_name.max'     => 'Họ không được vượt quá 30 ký tự.',
            'first_name.regex'   => 'Họ chứa ký tự không hợp lệ.',
            'last_name.max'      => 'Tên không được vượt quá 30 ký tự.',
            'last_name.regex'    => 'Tên chứa ký tự không hợp lệ.',

            // phone
            'phone.regex'        => 'Số điện thoại không hợp lệ. Định dạng mong đợi: 0xxxxxxxxx hoặc +84xxxxxxxxx (10 chữ số).',
            'phone.unique'       => 'Số điện thoại này đã được sử dụng bởi tài khoản khác.',
            'phone.max'          => 'Số điện thoại quá dài.',

            // link_social
            'link_social.url'    => 'Liên kết mạng xã hội phải là một URL hợp lệ (ví dụ: https://facebook.com/...).',
            'link_social.max'    => 'Liên kết mạng xã hội không được vượt quá 255 ký tự.',

            // avatar
            'avatar_url.image'   => 'Ảnh đại diện phải là một hình ảnh hợp lệ.',
            'avatar_url.mimes'   => 'Ảnh đại diện chỉ được phép có định dạng: jpg, jpeg, png, webp, gif.',
            'avatar_url.max'     => 'Ảnh đại diện không được vượt quá 2MB.',
            'avatar_url.dimensions' => 'Kích thước ảnh không hợp lệ. Yêu cầu tối thiểu 100x100 và tối đa 2000x2000.',

            // gender
            'gender.in'          => 'Giới tính không hợp lệ. Chỉ chấp nhận: male, female, other.',

            // dob
            'dob.date'           => 'Ngày sinh phải là một ngày hợp lệ.',
            'dob.after_or_equal' => 'Tuổi không được vượt quá 110 năm.',
            'dob.before_or_equal'=> 'Người dùng phải đủ 13 tuổi trở lên.',
        ];
    }

    /**
     * Kiểm tra bổ sung sau validate:
     * - Kiểm tra duplicate phone ở mức "digits-only" (so sánh không phân biệt +84/0/...).
     * - Kiểm tra host của link_social nằm trong danh sách domain mạng xã hội được chấp nhận.
     *
     * Ghi chú: kiểm tra duplicate phone bằng cách lấy danh sách users có phone và so sánh digits-only.
     * Nếu project của bạn có hàng triệu user thì nên lưu thêm cột normalized_phone (digits-only) + unique index để kiểm tra nhanh.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // --- phone duplicate check (digits-only)
            $phone = $this->input('phone');
            if (!empty($phone)) {
                $phoneDigits = preg_replace('/\D+/', '', $phone);
                if ($phoneDigits) {
                    // lấy các phone của user khác rồi so sánh digits-only
                    $rows = DB::table('users')
                        ->whereNotNull('phone')
                        ->where('id', '<>', Auth::id())
                        ->select('id', 'phone')
                        ->get();

                    foreach ($rows as $r) {
                        if ($r->phone) {
                            $p = preg_replace('/\D+/', '', $r->phone);
                            if ($p === $phoneDigits) {
                                $validator->errors()->add('phone', 'Số điện thoại này đã được đăng ký bởi tài khoản khác.');
                                break;
                            }
                        }
                    }
                }
            }

            // --- link_social host whitelist
            $link = $this->input('link_social');
            if (!empty($link)) {
                $host = parse_url($link, PHP_URL_HOST) ?: '';
                $host = mb_strtolower($host);
                $host = preg_replace('/^www\./', '', $host);

                $allowed = [
                    'facebook.com', 'm.facebook.com', 'instagram.com', 'linkedin.com',
                    'twitter.com', 'tiktok.com', 'youtube.com', 'github.com',
                    't.me', 'telegram.me'
                ];

                $ok = false;
                foreach ($allowed as $domain) {
                    if ($host === $domain || str_ends_with($host, '.'.$domain)) {
                        $ok = true;
                        break;
                    }
                }

                if (!$ok) {
                    $validator->errors()->add('link_social', 'Chỉ chấp nhận đường dẫn tới các mạng xã hội phổ biến (facebook, instagram, linkedin, twitter, tiktok, youtube, github, telegram).');
                }
            }
        });
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AdminProfileService;

use App\Models\User;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Admin\AdminPasswordRequest;
use App\Http\Requests\Admin\Admin\AdminProfileRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminController extends Controller
{
    protected AdminProfileService $profileService;

    public function __construct(AdminProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Bạn đã đăng xuất thành công.');
    }

    public function showProfile()
    {
        $data = Auth::user();
        return view('admin.profile.admin_profile', compact('data'));
    }

    public function updateProfile(AdminProfileRequest $request)
    {
        try {
            $user = $this->profileService->updateProfile(
                Auth::user(),
                $request->only(['name', 'first_name', 'last_name', 'phone', 'link_social']),
                $request->file('photo'),
                $request->boolean('remove_current_photo')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin cá nhân thành công.',
                'data' => [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'link_social' => $user->link_social,
                    'photo_url' => $user->photo ? asset('uploads/images/' . $user->photo) : asset('uploads/no_image.jpg'),
                ]
            ]);

        } catch (Throwable $e) {
            Log::error('Cập nhật profile thất bại trong controller', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thông tin thất bại. Vui lòng thử lại.'
            ], 500);
        }
    }

    public function removePhoto(Request $request)
    {
        $user = Auth::user();

        if (!$user || empty($user->photo)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có ảnh để xóa.'
            ], 400);
        }

        try {
            $this->profileService->updateProfile($user, [], null, true);

            return response()->json([
                'status' => 'success',
                'message' => 'Ảnh đại diện đã được xóa.',
                'photo' => asset('uploads/no_image.jpg')
            ]);

        } catch (Throwable $e) {
            Log::error('Xóa avatar thất bại', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Xóa avatar thất bại.'
            ], 500);
        }
    }

   
    public function showChangePassword()
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        return view('admin.profile.change_pass', compact('data'));
    }

    
    public function updatePassword(AdminPasswordRequest $request)
    {
        $user = User::find(Auth::id());

        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mật khẩu cũ không đúng.'
            ], 422);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Đổi mật khẩu thành công. Vui lòng đăng nhập lại!'
        ]);
    }
}

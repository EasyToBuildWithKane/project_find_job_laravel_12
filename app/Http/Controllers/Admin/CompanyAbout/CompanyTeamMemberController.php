<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\CompanyTeamMember\UpdateRequest;
use App\Models\CompanyTeamMember;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CompanyTeamMemberController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = CompanyTeamMember::query();

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.company_about.company_team_member.edit', $row->id);
                    return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Sửa
                            </a>';
                })
                ->editColumn('profile_image_url', function ($row) {
                    $imageUrl = $row->profile_image_url
                        ? asset($row->profile_image_url)
                        : asset('uploads/no_image.jpg');

                    return '<img src="' . e($imageUrl) . '" alt="Ảnh đại diện" 
                class="img-thumbnail rounded-circle" 
                style="height: 60px; width: 60px; object-fit: cover;">';
                })

                ->editColumn(
                    'is_featured',
                    fn($row) =>
                    $row->is_featured
                    ? '<span class="badge bg-success">Nổi bật</span>'
                    : '<span class="badge bg-secondary">Bình thường</span>'
                )
                ->rawColumns(['action', 'profile_image_url', 'is_featured'])
                ->make(true);
        }

        return view('admin.company_about.company_team_member.index');
    }

    public function edit(int $id)
    {
        try {
            $member = CompanyTeamMember::findOrFail($id);
            return view('admin.company_about.company_team_member.edit', compact('member'));
        } catch (Throwable $e) {
            Log::error('CompanyTeamMember edit error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.company_about.company_team_member.index')
                ->with('error', 'Không tìm thấy thành viên hoặc có lỗi xảy ra.');
        }
    }

    public function update(UpdateRequest $request, int $id)
    {
        $member = CompanyTeamMember::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $member) {
                $data = $request->validated();

                if ($request->hasFile('profile_image_url')) {
                    $data['profile_image_url'] = $this->uploadImage($request, $member);
                }

                $member->update($data);
            });

            return back()->with('success', 'Cập nhật thành công');
        } catch (Throwable $e) {
            Log::error('CompanyTeamMember update error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    /**
     * Upload ảnh vào public/uploads/team_members/
     * và xóa ảnh cũ nếu có.
     */
    private function uploadImage($request, CompanyTeamMember $member): string
    {
        $file = $request->file('profile_image_url');

        if (!$file->isValid()) {
            throw new RuntimeException('File upload không hợp lệ.');
        }

        // Thư mục lưu file trong public/
        $uploadPath = public_path('uploads/team_members');
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Xóa ảnh cũ (nếu có)
        if ($member->profile_image_url && file_exists(public_path($member->profile_image_url))) {
            @unlink(public_path($member->profile_image_url));
        }

        // Tạo tên file duy nhất
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $filename);

        return 'uploads/team_members/' . $filename;
    }

    /**
     * Xóa ảnh hồ sơ của thành viên
     */
    public function removeImage(int $id): JsonResponse
    {
        try {
            $member = CompanyTeamMember::findOrFail($id);

            if ($member->profile_image_url) {
                $path = public_path($member->profile_image_url);
                if (file_exists($path)) {
                    @unlink($path);
                }

                $member->update(['profile_image_url' => null]);
            }

            return response()->json(['message' => 'Ảnh đã được xoá']);
        } catch (Throwable $e) {
            Log::error('Remove CompanyTeamMember image error', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại'], 500);
        }
    }
}

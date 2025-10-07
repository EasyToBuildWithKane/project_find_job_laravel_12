<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\CompanyProfile\UpdateRequest;
use App\Http\Services\CompanyProfileService;
use App\Models\CompanyProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class CompanyProfileController extends Controller
{
    protected CompanyProfileService $profileService;

    public function __construct(CompanyProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**
     * Danh sách Company Profile (DataTables AJAX hoặc view)
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CompanyProfile::select(['id', 'section_key','headline', 'title','summary','body','cta_label','cta_link', 'featured_image_url']);

            return DataTables::of($query)
                ->addColumn('action', content: fn($row) =>
                    sprintf(
                        '<a href="%s" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Sửa</a>',
                        route('admin.company_about.company_profile.edit', $row->id)
                    )
                )
            ->editColumn('featured_image_url', function ($row) {
                    $imageUrl = $row->featured_image_url
                        ? asset($row->featured_image_url)
                        : asset('uploads/no_image.jpg');

                    return '<img src="' . e($imageUrl) . '" alt="Ảnh đại diện" 
                class="img-thumbnail rounded-circle" 
                style="height: 60px; width: 60px; object-fit: cover;">';
                })
                ->rawColumns(['action', 'featured_image_url'])
                ->make(true);
        }

        return view('admin.company_about.company_profile.index');
    }

    /**
     * Trang chỉnh sửa
     */
    public function edit(int $id)
    {
        try {
            $profile = CompanyProfile::findOrFail($id);
            return view('admin.company_about.company_profile.edit', compact('profile'));
        } catch (Throwable $e) {
            Log::error('CompanyProfile edit failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('admin.company_about.company_profile.index')
                ->with('error', 'Không tìm thấy bản ghi hoặc có lỗi xảy ra.');
        }
    }

    /**
     * Cập nhật CompanyProfile
     */
    public function update(UpdateRequest $request, int $id)
    {
        try {
            $this->profileService->update($id, $request->validated(), $request->file('featured_image_url'));

            return redirect()
                ->route('admin.company_about.company_profile.index')
                ->with('success', 'Cập nhật thành công.');
        } catch (Throwable $e) {
            Log::error('CompanyProfile update failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    /**
     * Xóa ảnh CompanyProfile
     */
    public function removeImage(int $id): JsonResponse
    {
        try {
            $this->profileService->removeImage($id);

            return response()->json([
                'status'  => 'success',
                'message' => 'Ảnh đã được xoá thành công.',
            ], 200);

        } catch (Throwable $e) {
            Log::error('Remove CompanyProfile image failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\CompanyProfile\UpdateRequest;
use App\Models\CompanyProfile;
use App\Services\Admin\CompanyAbout\CompanyProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CompanyProfileController extends Controller
{
    public function __construct(
        protected CompanyProfileService $service
    ) {
    }

    
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CompanyProfile::select(['section_key', 'title', 'headline', 'updated_at', 'summary', 'body', 'featured_image_url', 'cta_label', 'cta_link',]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('featured_image_url', function (CompanyProfile $profile) {
                    if ($profile->featured_image_url) {
                        return '<img src="' . asset($profile->featured_image_url) . '" 
                        alt="Image" width="80" class="rounded shadow">';
                    }
                    return '<span class="text-muted">No image</span>';
                })
                ->addColumn('actions', function (CompanyProfile $profile) {
                    return view('admin.company_about.company_profile._action_buttons', compact('profile'))->render();
                })

                ->rawColumns(['actions','featured_image_url'])
                ->make(true);
        }

        return view('admin.company_about.company_profile.index');
    }

   
    public function edit(string $sectionKey): JsonResponse
    {
        $profile = CompanyProfile::where('section_key', $sectionKey)->firstOrFail();

        $html = view('admin.company_about.company_profile._fields', compact('profile'))->render();

        return response()->json(['html' => $html]);
    }

   
    public function update(UpdateRequest $request)
    {

        try {
            $profile = CompanyProfile::where('section_key', $request->input('section_key'))->firstOrFail();

            $updatedProfile = $this->service->updateCompanyProfile(
                $profile,
                $request->only(['headline', 'title', 'summary', 'body', 'cta_label', 'cta_link']),
                $request->file('featured_image_url'),
                $request->boolean('remove_current_image')
            );

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thông tin section thành công.',
                'data' => $updatedProfile,
            ]);
        } catch (Throwable $e) {
            Log::error('Failed to update company profile section', [

                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Cập nhật thông tin section thất bại. Vui lòng thử lại.',
            ], 500);
        }
    }
    public function removeFeaturedImage(Request $request, string $sectionKey): JsonResponse
    {
        $profile = CompanyProfile::where('section_key', $sectionKey)->firstOrFail();

        if (!$profile || empty($profile->featured_image_url)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không có ảnh nổi bật để xóa.'
            ], 400);
        }

        try {
            $this->service->updateCompanyProfile($profile, [], null, true);

            return response()->json([
                'status' => 'success',
                'message' => 'Ảnh nổi bật đã được xóa.',
                'featured_image_url' => null
            ]);

        } catch (Throwable $e) {
            Log::error('Failed to remove featured image', [
                'section_key' => $sectionKey,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Xóa ảnh nổi bật thất bại. Vui lòng thử lại.'
            ], 500);
        }
    }
}

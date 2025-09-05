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
    ) {}

    /**
     * Danh sách các section trong Company Profile.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CompanyProfile::select(['section_key', 'title', 'headline', 'updated_at']);

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function (CompanyProfile $profile) {
                    return view('admin.company_about.company_profile._action_buttons', compact('profile'))->render();
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.company_about.company_profile.index');
    }

    /**
     * Render form chỉnh sửa section.
     */
    public function edit(string $sectionKey): JsonResponse
    {
        $profile = CompanyProfile::where('section_key', $sectionKey)->firstOrFail();

        $html = view('admin.company_about.company_profile._fields', compact('profile'))->render();

        return response()->json(['html' => $html]);
    }

    /**
     * Cập nhật section.
     */
    public function update(UpdateRequest $request, string $sectionKey): JsonResponse
    {
        try {
            $profile = $this->service->updateSection($sectionKey, $request->validated());

            return response()->json([
                'status' => 'success',
                'message' => __("Section ':key' đã được cập nhật!", ['key' => $sectionKey]),
                'data' => $profile,
            ]);
        } catch (Throwable $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'message' => app()->isLocal()
                    ? $e->getMessage()
                    : 'Có lỗi xảy ra, vui lòng thử lại.',
            ], 500);
        }
    }
}

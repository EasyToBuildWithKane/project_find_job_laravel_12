<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\CompanyProfile\UpdateRequest;
use App\Models\CompanyProfile;
use App\Services\Admin\CompanyAbout\CompanyProfileService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CompanyProfileController extends Controller
{
    protected CompanyProfileService $service;

    public function __construct(CompanyProfileService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CompanyProfile::query();

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('actions', function ($profile) {
                    return '<button class="btn btn-sm btn-primary btn-edit" data-section="' . $profile->section_key . '">Edit</button>';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('admin.company_about.company_profile.index');
    }
    public function edit($sectionKey)
    {

        $profile = CompanyProfile::where('section_key', $sectionKey)->firstOrFail();
        return view('admin.company_about.company_profile._fields', compact('profile'));
    }
    public function update(UpdateRequest $request, string $sectionKey): JsonResponse
    {
        try {
            $profile = $this->service->updateSection($sectionKey, $request->validated());

            return response()->json([
                'icon' => 'success',
                'title' => 'Cập nhật thành công',
                'text' => "Section '{$sectionKey}' đã được cập nhật!",
                'data' => $profile,
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Lỗi validation',
                'text' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'icon' => 'error',
                'title' => 'Cập nhật thất bại',
                'text' => $e->getMessage(),
            ], 422);
        }
    }

}

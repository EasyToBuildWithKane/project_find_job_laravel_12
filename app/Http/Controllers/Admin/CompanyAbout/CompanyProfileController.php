<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\CompanyProfile\UpdateRequest;
use App\Models\CompanyProfile;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables;

class CompanyProfileController extends Controller
{
    /**
     * Trang index + DataTables
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = CompanyProfile::query();

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.company_about.company_profile.edit', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                    ';
                })
                ->editColumn('featured_image_url', function ($row) {
                    if ($row->featured_image_url) {
                        return '<img src="' . asset($row->featured_image_url) . '" style="height:40px;width:auto;">';
                    }
                    return '-';
                })
                ->rawColumns(['action', 'featured_image_url'])

                ->make(true);
        }

        return view('admin.company_about.company_profile.index');
    }

    /**
     * Trang edit riêng
     */
    public function edit(int $id)
    {
        try {
            $profile = CompanyProfile::findOrFail($id);
            return view('admin.company_about.company_profile.edit', compact('profile'));
        } catch (Exception $e) {
            Log::error('CompanyProfile edit error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->route('admin.company_about.company_profile.index')
                ->with('error', 'Không tìm thấy bản ghi hoặc có lỗi xảy ra.');
        }
    }

    /**
     * Cập nhật CompanyProfile
     */
    public function update(UpdateRequest $request, int $id)
    {
        try {
            $profile = CompanyProfile::findOrFail($id);

            DB::transaction(function () use ($request, $profile) {
                $data = $request->validated();

                if ($request->hasFile('featured_image_url') && $request->file('featured_image_url')->isValid()) {
                    $file = $request->file('featured_image_url');
                    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/images'), $filename);
                    $data['featured_image_url'] = 'uploads/images/' . $filename;
                }

                $profile->update($data);
            });

            return redirect()->back()->with('success', 'Cập nhật thành công');

        } catch (Exception $e) {
            Log::error('CompanyProfile update error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    public function removeImage(int $id): JsonResponse
    {
        try {
            $profile = CompanyProfile::findOrFail($id);

            if ($profile->featured_image_url && file_exists(public_path($profile->featured_image_url))) {
                unlink(public_path($profile->featured_image_url));
            }

            $profile->featured_image_url = null;
            $profile->save();

            return response()->json(['message' => 'Ảnh đã được xoá'], 200);

        } catch (Exception $e) {
            Log::error('Remove CompanyProfile image error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại'], 500);
        }
    }


}

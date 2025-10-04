<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompanyAbout\CompanyTeamMember\UpdateRequest;
use App\Models\CompanyTeamMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CompanyTeamMemberController extends Controller
{
    /**
     * Trang index + DataTables
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CompanyTeamMember::query();

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.company_about.company_team_member.edit', $row->id);
                    return '<a href="' . $editUrl . '" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Sửa
                            </a>';
                })
                ->editColumn('profile_image_url', function ($row) {
                    if ($row->profile_image_url) {
                        return '<img src="' . asset($row->profile_image_url) . '" style="height:40px;width:auto;">';
                    }
                    return '-';
                })
                ->editColumn('is_featured', function ($row) {
                    return $row->is_featured ? '<span class="badge bg-success">Nổi bật</span>' : '<span class="badge bg-secondary">Bình thường</span>';
                })
                ->rawColumns(['action', 'profile_image_url', 'is_featured'])
                ->make(true);
        }

        return view('admin.company_about.company_team_member.index');
    }

    /**
     * Trang edit
     */
    public function edit(int $id)
    {
        try {
            $member = CompanyTeamMember::findOrFail($id);
            return view('admin.company_about.company_team_member.edit', compact('member'));
        } catch (Throwable $e) {
            Log::error('CompanyTeamMember edit error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->route('admin.company_about.company_team_member.index')
                ->with('error', 'Không tìm thấy thành viên hoặc có lỗi xảy ra.');
        }
    }

    /**
     * Cập nhật thông tin
     */
    public function update(UpdateRequest $request, int $id)
    {
        try {
            $member = CompanyTeamMember::findOrFail($id);

            $data = $request->validated();

            if ($request->hasFile('profile_image_url') && $request->file('profile_image_url')->isValid()) {
                if ($member->profile_image_url && file_exists(public_path($member->profile_image_url))) {
                    unlink(public_path($member->profile_image_url));
                }

                $file = $request->file('profile_image_url');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/team_members'), $filename);
                $data['profile_image_url'] = 'uploads/team_members/' . $filename;
            }

            $member->update($data);

            return redirect()
                ->route('admin.company_about.company_team_member.index')
                ->with('success', 'Cập nhật thành công');
        } catch (Throwable $e) {
            Log::error('CompanyTeamMember update error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại.');
        }
    }

    /**
     * Xoá ảnh hồ sơ
     */
    public function removeImage(int $id): JsonResponse
    {
        try {
            $member = CompanyTeamMember::findOrFail($id);

            if ($member->profile_image_url && file_exists(public_path($member->profile_image_url))) {
                unlink(public_path($member->profile_image_url));
            }

            $member->profile_image_url = null;
            $member->save();

            return response()->json(['message' => 'Ảnh đã được xoá'], 200);
        } catch (Throwable $e) {
            Log::error('Remove CompanyTeamMember image error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json(['message' => 'Có lỗi xảy ra, vui lòng thử lại'], 500);
        }
    }
}

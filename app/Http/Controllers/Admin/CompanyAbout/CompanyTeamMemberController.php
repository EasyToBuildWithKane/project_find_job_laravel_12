<?php

namespace App\Http\Controllers\Admin\CompanyAbout;

use App\Http\Controllers\Controller;
use App\Models\CompanyTeamMember;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CompanyTeamMemberController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = CompanyTeamMember::select([
                'id',
                'full_name',
                'job_title',
                'department',
                'location',
                'profile_image_url',
                'rating',
                'review_count',
                'social_links',
                'is_featured',
                'display_order',
            ]);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('profile_image_url', function (CompanyTeamMember $member) {
                    if ($member->profile_image_url) {
                        return '<img src="' . asset($member->profile_image_url) . '" 
                            alt="Avatar" width="60" class="rounded-circle shadow">';
                    }
                    return '<span class="text-muted">No image</span>';
                })
                ->editColumn('is_featured', fn($row) => $row->is_featured ? '✅' : '❌')
                ->addColumn('actions', function (CompanyTeamMember $row) {
                    return view('admin.company_about.company_team_member._action_buttons', compact('row'))->render();
                })
                ->rawColumns(['actions', 'profile_image_url'])
                ->make(true);
        }

        return view('admin.company_about.company_team_member.index');
    }

    public function edit(int $id): JsonResponse
    {
        $member = CompanyTeamMember::findOrFail($id);
        $html = view('admin.company_about.company_team_member.fields', compact('member'))->render();

        return response()->json(['html' => $html]);
    }

    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        try {
            $member = CompanyTeamMember::findOrFail($id);

            $data = $request->validated();

            // decode social_links nếu là JSON string
            if (!empty($data['social_links']) && is_string($data['social_links'])) {
                $decoded = json_decode($data['social_links'], true);
                $data['social_links'] = $decoded ?? [];
            }

            // xử lý boolean (checkbox)
            $data['is_featured'] = $request->boolean('is_featured');

            // xử lý ảnh
            if ($request->hasFile('profile_image_url')) {
                // xóa ảnh cũ nếu có
                if ($member->profile_image_url && Storage::disk('public')->exists(str_replace('storage/', '', $member->profile_image_url))) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $member->profile_image_url));
                }

                $file = $request->file('profile_image_url');
                $path = $file->store('uploads/team_members', 'public');
                $data['profile_image_url'] = 'storage/' . $path;
            }

            $member->update($data);

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật thành công',
                'data' => $member
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Lỗi: ' . $e->getMessage(),
            ], 500);
        }
    }
}

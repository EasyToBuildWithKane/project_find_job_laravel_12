<?php

namespace App\Services\Admin\CompanyAbout;

use App\Models\CompanyTeamMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class CompanyTeamMemberService
{
    /**
     * Cập nhật thông tin Team Member
     */
    public function updateMember(
        CompanyTeamMember $member,
        array $data,
        ?UploadedFile $profileImage = null,
        bool $removeCurrentImage = false
    ): CompanyTeamMember {
        DB::beginTransaction();
        try {
            // Gán giá trị cơ bản
            $member->full_name     = $data['full_name'] ?? $member->full_name;
            $member->job_title     = $data['job_title'] ?? $member->job_title;
            $member->department    = $data['department'] ?? $member->department;
            $member->location      = $data['location'] ?? $member->location;
            $member->rating        = $data['rating'] ?? $member->rating;
            $member->review_count  = $data['review_count'] ?? $member->review_count;
            $member->social_links  = $data['social_links'] ?? $member->social_links;
            $member->is_featured   = $data['is_featured'] ?? $member->is_featured;
            $member->display_order = $data['display_order'] ?? $member->display_order;

            // Xóa ảnh cũ nếu chọn remove
            if ($removeCurrentImage) {
                $this->deleteProfileImage($member);
                $member->profile_image_url = null;
            }

            // Upload ảnh mới
            if ($profileImage && $profileImage->isValid()) {
                $this->deleteProfileImage($member);
                $member->profile_image_url = $this->uploadProfileImage($profileImage);
            }

            $member->save();
            DB::commit();

            return $member;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Company team member update failed', [
                'member_id' => $member->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Upload ảnh profile
     */
    private function uploadProfileImage(UploadedFile $file): string
    {
        $filename = now()->format('YmdHis') . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/team_members'), $filename);

        return '/uploads/team_members/' . $filename;
    }

    /**
     * Xóa ảnh profile cũ
     */
    private function deleteProfileImage(CompanyTeamMember $member): void
    {
        if ($member->profile_image_url) {
            $filePath = public_path($member->profile_image_url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}

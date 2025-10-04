<?php

namespace App\Services\Admin\CompanyAbout;

use App\Models\CompanyTeamMember;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Throwable;

class CompanyTeamMemberService
{
    /**
     * Cập nhật thông tin Team Member
     *
     * @param  CompanyTeamMember  $member
     * @param  array              $data
     * @param  UploadedFile|null  $profileImage
     * @param  bool               $removeCurrentImage
     * @return CompanyTeamMember
     *
     * @throws QueryException|Throwable
     */
    public function updateMember(
        CompanyTeamMember $member,
        array $data,
        ?UploadedFile $profileImage = null,
        bool $removeCurrentImage = false
    ): CompanyTeamMember {
        return DB::transaction(function () use ($member, $data, $profileImage, $removeCurrentImage) {
            try {
                // Gán dữ liệu cơ bản
                $member->fill([
                    'full_name'     => $data['full_name']     ?? $member->full_name,
                    'job_title'     => $data['job_title']     ?? $member->job_title,
                    'department'    => $data['department']    ?? $member->department,
                    'location'      => $data['location']      ?? $member->location,
                    'rating'        => $data['rating']        ?? $member->rating,
                    'review_count'  => $data['review_count']  ?? $member->review_count,
                    'social_links'  => $data['social_links']  ?? $member->social_links,
                    'is_featured'   => $data['is_featured']   ?? $member->is_featured,
                    'display_order' => $data['display_order'] ?? $member->display_order,
                ]);

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

                return $member;
            } catch (Throwable $e) {
                Log::error('Company team member update failed', [
                    'member_id' => $member->id,
                    'data'      => $data,
                    'error'     => $e->getMessage(),
                    'trace'     => $e->getTraceAsString(),
                ]);
                throw $e;
            }
        });
    }


    private function uploadProfileImage(UploadedFile $file): string
    {
        $path = $file->storeAs(
            'uploads/team_members',
            now()->format('YmdHis') . '_' . $file->getClientOriginalName(),
            'public'
        );

        return 'storage/' . $path;
    }


    private function deleteProfileImage(CompanyTeamMember $member): void
    {
        if ($member->profile_image_url) {
            $relativePath = str_replace('storage/', '', $member->profile_image_url);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}

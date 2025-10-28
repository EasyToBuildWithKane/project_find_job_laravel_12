<?php

namespace App\Http\Services;

use App\Models\CompanyProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class CompanyProfileService
{
    /**
     * Cập nhật thông tin CompanyProfile
     */
    public function update(int $id, array $data, ?UploadedFile $image = null): CompanyProfile
    {
        DB::beginTransaction();

        try {
            $profile = CompanyProfile::findOrFail($id);

            // Xử lý upload ảnh mới
            if ($image && $image->isValid()) {
                $this->deleteImage($profile);
                $data['featured_image_url'] = $this->uploadImage($image);
            }

            $profile->fill($data);
            $profile->save();

            DB::commit();

            return $profile;
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error('Update CompanyProfile failed', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    /**
     * Xóa ảnh của CompanyProfile
     */
    public function removeImage(int $id): void
    {
        DB::beginTransaction();

        try {
            $profile = CompanyProfile::findOrFail($id);

            $this->deleteImage($profile);
            $profile->featured_image_url = null;
            $profile->save();

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Upload ảnh mới
     */
    private function uploadImage(UploadedFile $file): string
    {
        $filename = now()->format('YmdHis') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/images'), $filename);
        return 'uploads/images/' . $filename;
    }

    /**
     * Xóa ảnh cũ (nếu tồn tại)
     */
    private function deleteImage(CompanyProfile $profile): void
    {
        $path = public_path($profile->featured_image_url);
        if ($profile->featured_image_url && file_exists($path)) {
            @unlink($path);
        }
    }
}

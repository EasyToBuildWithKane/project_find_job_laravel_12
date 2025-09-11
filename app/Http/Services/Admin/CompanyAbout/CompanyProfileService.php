<?php

namespace App\Services\Admin\CompanyAbout;

use App\Models\CompanyProfile;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Exception;

class CompanyProfileService
{

    public function updateCompanyProfile(
        CompanyProfile $profile,
        array $data,
        ?UploadedFile $featuredImage = null,
        bool $removeCurrentImage = false
    ): CompanyProfile {
        DB::beginTransaction();
        try {
  
            $profile->headline = $data['headline'] ;
            $profile->title = $data['title'];
            $profile->summary = $data['summary'] ;
            $profile->body = $data['body'];
            // Handle featured image
            if ($removeCurrentImage) {
                $this->deleteFeaturedImage($profile);
                $profile->featured_image_url = null;
            }
            if($featuredImage && $featuredImage->isValid()) {
                $this->deleteFeaturedImage($profile);
                $profile->featured_image_url = $this->uploadFeaturedImage($featuredImage);
            }
            $profile->cta_label = $data['cta_label'] ?? $profile->cta_label;
            $profile->cta_link = $data['cta_link'] ?? $profile->cta_link;
            $profile->save();
            DB::commit();
            return $profile;
        } catch (Exception $e) {
            DB::rollback();
            Log::error('Company profile update failed', [
                'section_key' => $profile->section_key,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
    private function uploadFeaturedImage(UploadedFile $file): string
    {
        $filename = now()->format('YmdHis') . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/images'), $filename);
        return '/uploads/images/' . $filename;
    }
    private function deleteFeaturedImage(CompanyProfile $profile): void
    {
        if ($profile->featured_image_url) {
            $filePath = public_path($profile->featured_image_url);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}

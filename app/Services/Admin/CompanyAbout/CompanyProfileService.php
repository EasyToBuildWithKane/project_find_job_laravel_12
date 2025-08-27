<?php

namespace App\Services\Admin\CompanyAbout;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\DB;
use Exception;

class CompanyProfileService
{
   
    public function updateSection(string $sectionKey, array $data): CompanyProfile
    {
        return DB::transaction(function () use ($sectionKey, $data) {
            $profile = CompanyProfile::section($sectionKey)->first();

            if (!$profile) {
                throw new Exception("Section '$sectionKey' không tồn tại.");
            }

            $profile->update($data);

            return $profile;
        });
    }
}

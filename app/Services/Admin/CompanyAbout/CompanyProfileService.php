<?php

namespace App\Services\Admin\CompanyAbout;

use App\Models\CompanyProfile;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Throwable;

class CompanyProfileService
{
    /**
     * Cập nhật section theo section_key
     *
     * @param  string $sectionKey
     * @param  array  $data
     * @return CompanyProfile
     *
     * @throws ModelNotFoundException
     * @throws QueryException
     * @throws Throwable
     */
    public function updateSection(string $sectionKey, array $data): CompanyProfile
    {
        return DB::transaction(function () use ($sectionKey, $data) {
            $profile = CompanyProfile::where('section_key', $sectionKey)->first();

            if (!$profile) {
                throw new ModelNotFoundException("Section '{$sectionKey}' không tồn tại.");
            }

            $profile->fill($data);

            if ($profile->isDirty()) { 
                $profile->save();
            }

            return $profile;
        });
    }
}

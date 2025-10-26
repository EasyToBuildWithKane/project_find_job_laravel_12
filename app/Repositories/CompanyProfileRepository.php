<?php

namespace App\Repositories;

use App\Models\CompanyProfile;

class CompanyProfileRepository
{
    public function getAll()
    {
        return CompanyProfile::orderBy('id')->get();
    }

    public function findById(int $id): ?CompanyProfile
    {
        return CompanyProfile::find($id);
    }

    public function create(array $data): CompanyProfile
    {
        return CompanyProfile::create($data);
    }

    public function update(CompanyProfile $profile, array $data): CompanyProfile
    {
        $profile->update($data);
        return $profile;
    }

    public function delete(CompanyProfile $profile): bool
    {
        return $profile->delete();
    }
}






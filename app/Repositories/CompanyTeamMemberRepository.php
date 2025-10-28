<?php

namespace App\Repositories;

use App\Models\CompanyTeamMember;

class CompanyTeamMemberRepository
{
    public function getAll()
    {
        return CompanyTeamMember::orderBy('id')->get();
    }

    public function findById(int $id): ?CompanyTeamMember
    {
        return CompanyTeamMember::find($id);
    }

    public function create(array $data): CompanyTeamMember
    {
        return CompanyTeamMember::create($data);
    }

    public function update(CompanyTeamMember $member, array $data): CompanyTeamMember
    {
        $member->update($data);
        return $member;
    }

    public function delete(CompanyTeamMember $member): bool
    {
        return $member->delete();
    }
}






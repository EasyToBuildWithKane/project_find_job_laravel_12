<?php

namespace App\Repositories;

use App\Models\OrganizationType;

class OrganizationTypeRepository
{
    public function getAll()
    {
        return OrganizationType::orderBy('name')->get();
    }

    public function findById(int $id): ?OrganizationType
    {
        return OrganizationType::find($id);
    }

    public function create(array $data): OrganizationType
    {
        return OrganizationType::create($data);
    }

    public function update(OrganizationType $organizationType, array $data): OrganizationType
    {
        $organizationType->update($data);
        return $organizationType;
    }

    public function delete(OrganizationType $organizationType): bool
    {
        return $organizationType->delete();
    }
}







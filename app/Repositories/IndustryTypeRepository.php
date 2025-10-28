<?php

namespace App\Repositories;

use App\Models\IndustryType;

class IndustryTypeRepository
{
    public function getAll()
    {
        return IndustryType::orderBy('name')->get();
    }

    public function findById(int $id): ?IndustryType
    {
        return IndustryType::find($id);
    }

    public function create(array $data): IndustryType
    {
        return IndustryType::create($data);
    }

    public function update(IndustryType $industryType, array $data): IndustryType
    {
        $industryType->update($data);
        return $industryType;
    }

    public function delete(IndustryType $industryType): bool
    {
        return $industryType->delete();
    }
}







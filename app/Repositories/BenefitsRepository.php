<?php

namespace App\Repositories;

use App\Models\Benefits;

class BenefitsRepository
{
    public function getAll()
    {
        return Benefits::orderBy('name')->get();
    }

    public function findById(int $id): ?Benefits
    {
        return Benefits::find($id);
    }

    public function create(array $data): Benefits
    {
        return Benefits::create($data);
    }

    public function update(Benefits $benefits, array $data): Benefits
    {
        $benefits->update($data);
        return $benefits;
    }

    public function delete(Benefits $benefits): bool
    {
        return $benefits->delete();
    }
}







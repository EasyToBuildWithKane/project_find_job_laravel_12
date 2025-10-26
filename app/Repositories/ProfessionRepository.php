<?php

namespace App\Repositories;

use App\Models\Profession;

class ProfessionRepository
{
    public function getAll()
    {
        return Profession::orderBy('name')->get();
    }

    public function findById(int $id): ?Profession
    {
        return Profession::find($id);
    }

    public function create(array $data): Profession
    {
        return Profession::create($data);
    }

    public function update(Profession $profession, array $data): Profession
    {
        $profession->update($data);
        return $profession;
    }

    public function delete(Profession $profession): bool
    {
        return $profession->delete();
    }
}







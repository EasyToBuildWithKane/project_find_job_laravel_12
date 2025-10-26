<?php

namespace App\Repositories;

use App\Models\TeamSize;

class TeamSizeRepository
{
    public function getAll()
    {
        return TeamSize::orderBy('name')->get();
    }

    public function findById(int $id): ?TeamSize
    {
        return TeamSize::find($id);
    }

    public function create(array $data): TeamSize
    {
        return TeamSize::create($data);
    }

    public function update(TeamSize $teamSize, array $data): TeamSize
    {
        $teamSize->update($data);
        return $teamSize;
    }

    public function delete(TeamSize $teamSize): bool
    {
        return $teamSize->delete();
    }
}







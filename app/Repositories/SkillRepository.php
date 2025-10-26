<?php

namespace App\Repositories;

use App\Models\Skill;

class SkillRepository
{
    public function getAll()
    {
        return Skill::orderBy('name')->get();
    }

    public function findById(int $id): ?Skill
    {
        return Skill::find($id);
    }

    public function create(array $data): Skill
    {
        return Skill::create($data);
    }

    public function update(Skill $skill, array $data): Skill
    {
        $skill->update($data);
        return $skill;
    }

    public function delete(Skill $skill): bool
    {
        return $skill->delete();
    }
}







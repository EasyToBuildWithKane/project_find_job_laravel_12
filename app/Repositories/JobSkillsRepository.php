<?php

namespace App\Repositories;

use App\Models\JobSkills;

class JobSkillsRepository
{
    public function getAll()
    {
        return JobSkills::with(['job','skill'])->orderByDesc('id')->get();
    }

    public function findById(int $id): ?JobSkills
    {
        return JobSkills::find($id);
    }

    public function create(array $data): JobSkills
    {
        return JobSkills::create($data);
    }

    public function update(JobSkills $jobSkills, array $data): JobSkills
    {
        $jobSkills->update($data);
        return $jobSkills;
    }

    public function delete(JobSkills $jobSkills): bool
    {
        return $jobSkills->delete();
    }
}







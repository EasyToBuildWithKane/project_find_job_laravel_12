<?php

namespace App\Repositories;

use App\Models\JobExperience;

class JobExperienceRepository
{
    public function getAll()
    {
        return JobExperience::latest()->get();
    }

    public function find($id)
    {
        return JobExperience::findOrFail($id);
    }

    public function create(array $data)
    {
        return JobExperience::create($data);
    }

    public function update($id, array $data)
    {
        $experience = $this->find($id);
        $experience->update($data);
        return $experience;
    }

    public function delete($id)
    {
        $experience = $this->find($id);
        return $experience->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\JobType;

class JobTypeRepository
{
    public function getAll()
    {
        return JobType::latest()->get();
    }

    public function find($id)
    {
        return JobType::findOrFail($id);
    }

    public function create(array $data)
    {
        return JobType::create($data);
    }

    public function update($id, array $data)
    {
        $jobType = $this->find($id);
        $jobType->update($data);
        return $jobType;
    }

    public function delete($id)
    {
        $jobType = $this->find($id);
        return $jobType->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\Job;

class JobRepository
{
    public function getAll()
    {
        return Job::with([
            'company',
            'category',
            'role',
            'experience',
            'education',
            'jobType',
            'salaryType',
            'city',
            'state',
            'country'
        ])->latest()->get();
    }

    public function find($id)
    {
        return Job::with([
            'company',
            'category',
            'role',
            'experience',
            'education',
            'jobType',
            'salaryType',
            'city',
            'state',
            'country'
        ])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Job::create($data);
    }

    public function update($id, array $data)
    {
        $job = $this->find($id);
        $job->update($data);
        return $job;
    }

    public function delete($id)
    {
        $job = $this->find($id);
        return $job->delete();
    }
}

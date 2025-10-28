<?php

namespace App\Repositories;

use App\Models\JobTag;

class JobTagRepository
{
    public function getAll()
    {
        return JobTag::with(['job','tag'])->orderByDesc('id')->get();
    }

    public function findById(int $id): ?JobTag
    {
        return JobTag::find($id);
    }

    public function create(array $data): JobTag
    {
        return JobTag::create($data);
    }

    public function update(JobTag $jobTag, array $data): JobTag
    {
        $jobTag->update($data);
        return $jobTag;
    }

    public function delete(JobTag $jobTag): bool
    {
        return $jobTag->delete();
    }
}







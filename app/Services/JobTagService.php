<?php

namespace App\Services;

use App\Repositories\JobTagRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class JobTagService
{
    protected $jobTagRepository;

    public function __construct(JobTagRepository $jobTagRepository)
    {
        $this->jobTagRepository = $jobTagRepository;
    }

    public function getAllJobTags()
    {
        return $this->jobTagRepository->getAll();
    }

    public function createJobTag(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->jobTagRepository->create($data);
        });
    }

    public function updateJobTag(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $jobTag = $this->jobTagRepository->findById($id);
            return $this->jobTagRepository->update($jobTag, $data);
        });
    }

    public function deleteJobTag(int $id)
    {
        return DB::transaction(function () use ($id) {
            $jobTag = $this->jobTagRepository->findById($id);
            return $this->jobTagRepository->delete($jobTag);
        });
    }
}







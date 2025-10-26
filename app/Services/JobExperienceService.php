<?php

namespace App\Services;

use App\Repositories\JobExperienceRepository;
use Illuminate\Support\Str;

class JobExperienceService
{
    protected $jobExperienceRepository;

    public function __construct(JobExperienceRepository $jobExperienceRepository)
    {
        $this->jobExperienceRepository = $jobExperienceRepository;
    }

    public function getAll()
    {
        return $this->jobExperienceRepository->getAll();
    }

    public function find($id)
    {
        return $this->jobExperienceRepository->find($id);
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->jobExperienceRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->jobExperienceRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->jobExperienceRepository->delete($id);
    }
}

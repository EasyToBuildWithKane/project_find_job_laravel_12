<?php

namespace App\Services;

use App\Repositories\JobSkillsRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class JobSkillsService
{
    protected $jobSkillsRepository;

    public function __construct(JobSkillsRepository $jobSkillsRepository)
    {
        $this->jobSkillsRepository = $jobSkillsRepository;
    }

    public function getAllJobSkills()
    {
        return $this->jobSkillsRepository->getAll();
    }

    public function createJobSkills(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->jobSkillsRepository->create($data);
        });
    }

    public function updateJobSkills(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $entity = $this->jobSkillsRepository->findById($id);
            return $this->jobSkillsRepository->update($entity, $data);
        });
    }

    public function deleteJobSkills(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entity = $this->jobSkillsRepository->findById($id);
            return $this->jobSkillsRepository->delete($entity);
        });
    }
}







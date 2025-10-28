<?php

namespace App\Services;

use App\Repositories\JobBenefitsRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class JobBenefitsService
{
    protected $jobBenefitsRepository;

    public function __construct(JobBenefitsRepository $jobBenefitsRepository)
    {
        $this->jobBenefitsRepository = $jobBenefitsRepository;
    }

    public function getAllJobBenefits()
    {
        return $this->jobBenefitsRepository->getAll();
    }

    public function createJobBenefits(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->jobBenefitsRepository->create($data);
        });
    }

    public function updateJobBenefits(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $entity = $this->jobBenefitsRepository->findById($id);
            return $this->jobBenefitsRepository->update($entity, $data);
        });
    }

    public function deleteJobBenefits(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entity = $this->jobBenefitsRepository->findById($id);
            return $this->jobBenefitsRepository->delete($entity);
        });
    }
}







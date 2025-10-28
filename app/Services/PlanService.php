<?php

namespace App\Services;

use App\Repositories\PlanRepository;
use Illuminate\Support\Facades\DB;

class PlanService
{
    protected $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function getAllPlans()
    {
        return $this->planRepository->getAll();
    }

    public function createPlan(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->planRepository->create($data);
        });
    }

    public function updatePlan(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $plan = $this->planRepository->findById($id);
            return $this->planRepository->update($plan, $data);
        });
    }

    public function deletePlan(int $id)
    {
        return DB::transaction(function () use ($id) {
            $plan = $this->planRepository->findById($id);
            return $this->planRepository->delete($plan);
        });
    }

    public function getById(int $id)
    {
        return $this->planRepository->findById($id);
    }
}



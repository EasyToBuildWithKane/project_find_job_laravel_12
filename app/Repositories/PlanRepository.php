<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    public function getAll()
    {
        return Plan::orderBy('id')->get();
    }

    public function findById(int $id): ?Plan
    {
        return Plan::find($id);
    }

    public function create(array $data): Plan
    {
        return Plan::create($data);
    }

    public function update(Plan $plan, array $data): Plan
    {
        $plan->update($data);
        return $plan;
    }

    public function delete(Plan $plan): bool
    {
        return $plan->delete();
    }
}






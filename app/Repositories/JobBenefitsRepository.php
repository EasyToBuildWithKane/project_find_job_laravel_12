<?php

namespace App\Repositories;

use App\Models\JobBenefits;

class JobBenefitsRepository
{
    public function getAll()
    {
        return JobBenefits::with(['job','benefit'])->orderByDesc('id')->get();
    }

    public function findById(int $id): ?JobBenefits
    {
        return JobBenefits::find($id);
    }

    public function create(array $data): JobBenefits
    {
        return JobBenefits::create($data);
    }

    public function update(JobBenefits $jobBenefits, array $data): JobBenefits
    {
        $jobBenefits->update($data);
        return $jobBenefits;
    }

    public function delete(JobBenefits $jobBenefits): bool
    {
        return $jobBenefits->delete();
    }
}







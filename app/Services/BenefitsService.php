<?php

namespace App\Services;

use App\Repositories\BenefitsRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class BenefitsService
{
    protected $benefitsRepository;

    public function __construct(BenefitsRepository $benefitsRepository)
    {
        $this->benefitsRepository = $benefitsRepository;
    }

    public function getAllBenefits()
    {
        return $this->benefitsRepository->getAll();
    }

    public function createBenefits(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->benefitsRepository->create($data);
        });
    }

    public function updateBenefits(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $benefits = $this->benefitsRepository->findById($id);
            return $this->benefitsRepository->update($benefits, $data);
        });
    }

    public function deleteBenefits(int $id)
    {
        return DB::transaction(function () use ($id) {
            $benefits = $this->benefitsRepository->findById($id);
            return $this->benefitsRepository->delete($benefits);
        });
    }
}







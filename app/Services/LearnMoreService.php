<?php

namespace App\Services;

use App\Repositories\LearnMoreRepository;
use Illuminate\Support\Facades\DB;

class LearnMoreService
{
    protected $learnMoreRepository;

    public function __construct(LearnMoreRepository $learnMoreRepository)
    {
        $this->learnMoreRepository = $learnMoreRepository;
    }

    public function getAllLearnMores()
    {
        return $this->learnMoreRepository->getAll();
    }

    public function createLearnMore(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->learnMoreRepository->create($data);
        });
    }

    public function updateLearnMore(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $entity = $this->learnMoreRepository->findById($id);
            return $this->learnMoreRepository->update($entity, $data);
        });
    }

    public function deleteLearnMore(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entity = $this->learnMoreRepository->findById($id);
            return $this->learnMoreRepository->delete($entity);
        });
    }
}







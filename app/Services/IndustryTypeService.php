<?php

namespace App\Services;

use App\Repositories\IndustryTypeRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class IndustryTypeService
{
    protected $industryTypeRepository;

    public function __construct(IndustryTypeRepository $industryTypeRepository)
    {
        $this->industryTypeRepository = $industryTypeRepository;
    }

    public function getAllIndustryTypes()
    {
        return $this->industryTypeRepository->getAll();
    }

    public function createIndustryType(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->industryTypeRepository->create($data);
        });
    }

    public function updateIndustryType(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $entity = $this->industryTypeRepository->findById($id);
            return $this->industryTypeRepository->update($entity, $data);
        });
    }

    public function deleteIndustryType(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entity = $this->industryTypeRepository->findById($id);
            return $this->industryTypeRepository->delete($entity);
        });
    }
}







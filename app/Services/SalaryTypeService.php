<?php

namespace App\Services;

use App\Repositories\SalaryTypeRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Exception;

class SalaryTypeService
{
    protected $salaryTypeRepository;

    public function __construct(SalaryTypeRepository $salaryTypeRepository)
    {
        $this->salaryTypeRepository = $salaryTypeRepository;
    }

    public function getAll()
    {
        return $this->salaryTypeRepository->getAll();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->salaryTypeRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->salaryTypeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->salaryTypeRepository->delete($id);
    }

    public function find($id)
    {
        return $this->salaryTypeRepository->find($id);
    }
}


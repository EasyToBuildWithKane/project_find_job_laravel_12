<?php

namespace App\Repositories;

use App\Models\SalaryType;
use Illuminate\Support\Facades\Log;
use Exception;

class SalaryTypeRepository
{
    public function getAll()
    {
        return SalaryType::latest()->get();
    }

    public function find($id)
    {
        return SalaryType::findOrFail($id);
    }

    public function create(array $data)
    {
        return SalaryType::create($data);
    }

    public function update($id, array $data)
    {
        $salaryType = $this->find($id);
        $salaryType->update($data);
        return $salaryType;
    }

    public function delete($id)
    {
        $salaryType = $this->find($id);
        return $salaryType->delete();
    }
}


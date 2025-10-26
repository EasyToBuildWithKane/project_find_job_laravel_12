<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository
{
    public function getAll()
    {
        return Company::with(['user', 'industryType', 'organizationType', 'teamSize', 'cityRel', 'stateRel', 'countryRel'])
            ->latest()->get();
    }

    public function find($id)
    {
        return Company::with(['user', 'industryType', 'organizationType', 'teamSize', 'cityRel', 'stateRel', 'countryRel'])->findOrFail($id);
    }

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function update($id, array $data)
    {
        $company = $this->find($id);
        $company->update($data);
        return $company;
    }

    public function delete($id)
    {
        $company = $this->find($id);
        return $company->delete();
    }
}

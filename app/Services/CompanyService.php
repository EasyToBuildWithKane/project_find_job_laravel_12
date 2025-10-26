<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use Illuminate\Support\Str;

class CompanyService
{
    protected $companyRepository;

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function getAll()
    {
        return $this->companyRepository->getAll();
    }

    public function find($id)
    {
        return $this->companyRepository->find($id);
    }

    public function create(array $data)
    {
        if(isset($data['name'])) $data['slug'] = Str::slug($data['name']);
        return $this->companyRepository->create($data);
    }

    public function update($id, array $data)
    {
        if(isset($data['name'])) $data['slug'] = Str::slug($data['name']);
        return $this->companyRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->companyRepository->delete($id);
    }
}

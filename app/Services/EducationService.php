<?php

namespace App\Services;

use App\Repositories\EducationRepository;
use Illuminate\Support\Str;

class EducationService
{
    protected $educationRepository;

    public function __construct(EducationRepository $educationRepository)
    {
        $this->educationRepository = $educationRepository;
    }

    public function getAll()
    {
        return $this->educationRepository->getAll();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->educationRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->educationRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->educationRepository->delete($id);
    }

    public function find($id)
    {
        return $this->educationRepository->find($id);
    }
}

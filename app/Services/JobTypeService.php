<?php

namespace App\Services;

use App\Repositories\JobTypeRepository;
use Illuminate\Support\Str;

class JobTypeService
{
    protected $jobTypeRepository;

    public function __construct(JobTypeRepository $jobTypeRepository)
    {
        $this->jobTypeRepository = $jobTypeRepository;
    }

    public function getAll()
    {
        return $this->jobTypeRepository->getAll();
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->jobTypeRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->jobTypeRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->jobTypeRepository->delete($id);
    }

    public function find($id)
    {
        return $this->jobTypeRepository->find($id);
    }
}

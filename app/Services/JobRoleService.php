<?php

namespace App\Services;

use App\Repositories\JobRoleRepository;
use Illuminate\Support\Str;

class JobRoleService
{
    protected $jobRoleRepository;

    public function __construct(JobRoleRepository $jobRoleRepository)
    {
        $this->jobRoleRepository = $jobRoleRepository;
    }

    public function getAll()
    {
        return $this->jobRoleRepository->getAll();
    }

    public function find($id)
    {
        return $this->jobRoleRepository->find($id);
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->jobRoleRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        return $this->jobRoleRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->jobRoleRepository->delete($id);
    }
}

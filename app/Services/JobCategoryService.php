<?php

namespace App\Services;

use App\Repositories\JobCategoryRepository;
use Illuminate\Support\Str;

class JobCategoryService
{
    protected $jobCategoryRepository;

    public function __construct(JobCategoryRepository $jobCategoryRepository)
    {
        $this->jobCategoryRepository = $jobCategoryRepository;
    }

    public function getAll()
    {
        return $this->jobCategoryRepository->getAll();
    }

    public function find($id)
    {
        return $this->jobCategoryRepository->find($id);
    }

    public function create(array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['show_at_popular'] = $data['show_at_popular'] ?? 0;
        $data['show_at_featured'] = $data['show_at_featured'] ?? 0;
        return $this->jobCategoryRepository->create($data);
    }

    public function update($id, array $data)
    {
        $data['slug'] = Str::slug($data['name']);
        $data['show_at_popular'] = $data['show_at_popular'] ?? 0;
        $data['show_at_featured'] = $data['show_at_featured'] ?? 0;
        return $this->jobCategoryRepository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->jobCategoryRepository->delete($id);
    }
}

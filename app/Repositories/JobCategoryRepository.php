<?php

namespace App\Repositories;

use App\Models\JobCategory;

class JobCategoryRepository
{
    public function getAll()
    {
        return JobCategory::latest()->get();
    }

    public function find($id)
    {
        return JobCategory::findOrFail($id);
    }

    public function create(array $data)
    {
        return JobCategory::create($data);
    }

    public function update($id, array $data)
    {
        $category = $this->find($id);
        $category->update($data);
        return $category;
    }

    public function delete($id)
    {
        $category = $this->find($id);
        return $category->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\Education;

class EducationRepository
{
    public function getAll()
    {
        return Education::latest()->get();
    }

    public function find($id)
    {
        return Education::findOrFail($id);
    }

    public function create(array $data)
    {
        return Education::create($data);
    }

    public function update($id, array $data)
    {
        $education = $this->find($id);
        $education->update($data);
        return $education;
    }

    public function delete($id)
    {
        $education = $this->find($id);
        return $education->delete();
    }
}

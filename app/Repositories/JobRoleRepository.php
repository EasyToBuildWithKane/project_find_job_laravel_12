<?php

namespace App\Repositories;

use App\Models\JobRole;

class JobRoleRepository
{
    public function getAll()
    {
        return JobRole::latest()->get();
    }

    public function find($id)
    {
        return JobRole::findOrFail($id);
    }

    public function create(array $data)
    {
        return JobRole::create($data);
    }

    public function update($id, array $data)
    {
        $role = $this->find($id);
        $role->update($data);
        return $role;
    }

    public function delete($id)
    {
        $role = $this->find($id);
        return $role->delete();
    }
}

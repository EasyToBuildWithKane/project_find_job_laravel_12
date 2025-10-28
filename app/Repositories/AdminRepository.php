<?php

namespace App\Repositories;

use App\Models\Admin;

class AdminRepository
{
    public function getAll()
    {
        return Admin::orderBy('id')->get();
    }

    public function findById(int $id): ?Admin
    {
        return Admin::find($id);
    }

    public function create(array $data): Admin
    {
        return Admin::create($data);
    }

    public function update(Admin $admin, array $data): Admin
    {
        $admin->update($data);
        return $admin;
    }

    public function delete(Admin $admin): bool
    {
        return $admin->delete();
    }
}






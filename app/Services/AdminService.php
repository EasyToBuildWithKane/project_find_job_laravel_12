<?php

namespace App\Services;

use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;

class AdminService
{
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function getAllAdmins()
    {
        return $this->adminRepository->getAll();
    }

    public function createAdmin(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->adminRepository->create($data);
        });
    }

    public function updateAdmin(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $admin = $this->adminRepository->findById($id);
            return $this->adminRepository->update($admin, $data);
        });
    }

    public function deleteAdmin(int $id)
    {
        return DB::transaction(function () use ($id) {
            $admin = $this->adminRepository->findById($id);
            return $this->adminRepository->delete($admin);
        });
    }
}






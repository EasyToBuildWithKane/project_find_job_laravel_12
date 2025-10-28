<?php

namespace App\Services;

use App\Repositories\CompanyProfileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyProfileService
{
    protected $companyProfileRepository;

    public function __construct(CompanyProfileRepository $companyProfileRepository)
    {
        $this->companyProfileRepository = $companyProfileRepository;
    }

    public function getAllCompanyProfiles()
    {
        return $this->companyProfileRepository->getAll();
    }

    public function createCompanyProfile(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->companyProfileRepository->create($data);
        });
    }

    public function updateCompanyProfile(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->companyProfileRepository->findById($id);
            return $this->companyProfileRepository->update($item, $data);
        });
    }

    public function deleteCompanyProfile(int $id)
    {
        return DB::transaction(function () use ($id) {
            $item = $this->companyProfileRepository->findById($id);
            return $this->companyProfileRepository->delete($item);
        });
    }

    public function getById(int $id)
    {
        return $this->companyProfileRepository->findById($id);
    }

    public function removeImage(int $id): void
    {
        $item = $this->companyProfileRepository->findById($id);
        if (!$item) {
            return;
        }

        if ($item->featured_image_url) {
            $path = public_path($item->featured_image_url);
            try {
                if (file_exists($path)) {
                    @unlink($path);
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to remove CompanyProfile image', [
                    'id' => $id,
                    'path' => $path,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->companyProfileRepository->update($item, [
            'featured_image_url' => null,
        ]);
    }
}



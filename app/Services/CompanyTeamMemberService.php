<?php

namespace App\Services;

use App\Repositories\CompanyTeamMemberRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompanyTeamMemberService
{
    protected $companyTeamMemberRepository;

    public function __construct(CompanyTeamMemberRepository $companyTeamMemberRepository)
    {
        $this->companyTeamMemberRepository = $companyTeamMemberRepository;
    }

    public function getAllCompanyTeamMembers()
    {
        return $this->companyTeamMemberRepository->getAll();
    }

    public function createCompanyTeamMember(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->companyTeamMemberRepository->create($data);
        });
    }

    public function updateCompanyTeamMember(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->companyTeamMemberRepository->findById($id);
            return $this->companyTeamMemberRepository->update($item, $data);
        });
    }

    public function deleteCompanyTeamMember(int $id)
    {
        return DB::transaction(function () use ($id) {
            $item = $this->companyTeamMemberRepository->findById($id);
            return $this->companyTeamMemberRepository->delete($item);
        });
    }

    public function getById(int $id)
    {
        return $this->companyTeamMemberRepository->findById($id);
    }

    public function removeImage(int $id): void
    {
        $member = $this->companyTeamMemberRepository->findById($id);
        if (!$member) {
            return;
        }

        if ($member->profile_image_url) {
            $path = public_path($member->profile_image_url);
            try {
                if (file_exists($path)) {
                    @unlink($path);
                }
            } catch (\Throwable $e) {
                Log::warning('Failed to remove CompanyTeamMember image', [
                    'id' => $id,
                    'path' => $path,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $this->companyTeamMemberRepository->update($member, [
            'profile_image_url' => null,
        ]);
    }
}



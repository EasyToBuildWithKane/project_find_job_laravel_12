<?php

namespace App\Services;

use App\Repositories\OrganizationTypeRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class OrganizationTypeService
{
    protected $organizationTypeRepository;

    public function __construct(OrganizationTypeRepository $organizationTypeRepository)
    {
        $this->organizationTypeRepository = $organizationTypeRepository;
    }

    public function getAllOrganizationTypes()
    {
        return $this->organizationTypeRepository->getAll();
    }

    public function createOrganizationType(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->organizationTypeRepository->create($data);
        });
    }

    public function updateOrganizationType(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $entity = $this->organizationTypeRepository->findById($id);
            return $this->organizationTypeRepository->update($entity, $data);
        });
    }

    public function deleteOrganizationType(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entity = $this->organizationTypeRepository->findById($id);
            return $this->organizationTypeRepository->delete($entity);
        });
    }
}







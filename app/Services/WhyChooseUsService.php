<?php

namespace App\Services;

use App\Repositories\WhyChooseUsRepository;
use Illuminate\Support\Facades\DB;

class WhyChooseUsService
{
    protected $whyChooseUsRepository;

    public function __construct(WhyChooseUsRepository $whyChooseUsRepository)
    {
        $this->whyChooseUsRepository = $whyChooseUsRepository;
    }

    public function getAllWhyChooseUs()
    {
        return $this->whyChooseUsRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->whyChooseUsRepository->findById($id);
    }

    public function createWhyChooseUs(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->whyChooseUsRepository->create($data);
        });
    }

    public function updateWhyChooseUs(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $item = $this->whyChooseUsRepository->findById($id);
            return $this->whyChooseUsRepository->update($item, $data);
        });
    }

    public function deleteWhyChooseUs(int $id)
    {
        return DB::transaction(function () use ($id) {
            $item = $this->whyChooseUsRepository->findById($id);
            return $this->whyChooseUsRepository->delete($item);
        });
    }
}



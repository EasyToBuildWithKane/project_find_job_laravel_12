<?php

namespace App\Services;

use App\Repositories\CounterRepository;
use Illuminate\Support\Facades\DB;

class CounterService
{
    protected $counterRepository;

    public function __construct(CounterRepository $counterRepository)
    {
        $this->counterRepository = $counterRepository;
    }

    public function getAllCounters()
    {
        return $this->counterRepository->getAll();
    }

    public function createCounter(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->counterRepository->create($data);
        });
    }

    public function updateCounter(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $entity = $this->counterRepository->findById($id);
            return $this->counterRepository->update($entity, $data);
        });
    }

    public function deleteCounter(int $id)
    {
        return DB::transaction(function () use ($id) {
            $entity = $this->counterRepository->findById($id);
            return $this->counterRepository->delete($entity);
        });
    }
}







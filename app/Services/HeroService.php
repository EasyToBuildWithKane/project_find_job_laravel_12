<?php

namespace App\Services;

use App\Repositories\HeroRepository;
use Illuminate\Support\Facades\DB;
use Exception;

class HeroService
{
    protected $heroRepository;

    public function __construct(HeroRepository $heroRepository)
    {
        $this->heroRepository = $heroRepository;
    }

    public function getAllHeroes()
    {
        return $this->heroRepository->getAll();
    }

    public function createHero(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->heroRepository->create($data);
        });
    }

    public function updateHero(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $hero = $this->heroRepository->findById($id);
            return $this->heroRepository->update($hero, $data);
        });
    }

    public function deleteHero(int $id)
    {
        return DB::transaction(function () use ($id) {
            $hero = $this->heroRepository->findById($id);
            return $this->heroRepository->delete($hero);
        });
    }
}







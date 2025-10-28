<?php

namespace App\Repositories;

use App\Models\Hero;

class HeroRepository
{
    public function getAll()
    {
        return Hero::orderByDesc('id')->get();
    }

    public function findById(int $id): ?Hero
    {
        return Hero::find($id);
    }

    public function create(array $data): Hero
    {
        return Hero::create($data);
    }

    public function update(Hero $hero, array $data): Hero
    {
        $hero->update($data);
        return $hero;
    }

    public function delete(Hero $hero): bool
    {
        return $hero->delete();
    }
}







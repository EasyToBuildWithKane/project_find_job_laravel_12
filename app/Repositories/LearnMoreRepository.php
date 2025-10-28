<?php

namespace App\Repositories;

use App\Models\LearnMore;

class LearnMoreRepository
{
    public function getAll()
    {
        return LearnMore::orderByDesc('id')->get();
    }

    public function findById(int $id): ?LearnMore
    {
        return LearnMore::find($id);
    }

    public function create(array $data): LearnMore
    {
        return LearnMore::create($data);
    }

    public function update(LearnMore $learnMore, array $data): LearnMore
    {
        $learnMore->update($data);
        return $learnMore;
    }

    public function delete(LearnMore $learnMore): bool
    {
        return $learnMore->delete();
    }
}







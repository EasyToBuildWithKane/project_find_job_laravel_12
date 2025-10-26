<?php

namespace App\Repositories;

use App\Models\Counter;

class CounterRepository
{
    public function getAll()
    {
        return Counter::orderByDesc('id')->get();
    }

    public function findById(int $id): ?Counter
    {
        return Counter::find($id);
    }

    public function create(array $data): Counter
    {
        return Counter::create($data);
    }

    public function update(Counter $counter, array $data): Counter
    {
        $counter->update($data);
        return $counter;
    }

    public function delete(Counter $counter): bool
    {
        return $counter->delete();
    }
}







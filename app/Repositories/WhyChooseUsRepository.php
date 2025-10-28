<?php

namespace App\Repositories;

use App\Models\WhyChooseUs;

class WhyChooseUsRepository
{
    public function getAll()
    {
        return WhyChooseUs::orderBy('id')->get();
    }

    public function findById(int $id): ?WhyChooseUs
    {
        return WhyChooseUs::find($id);
    }

    public function create(array $data): WhyChooseUs
    {
        return WhyChooseUs::create($data);
    }

    public function update(WhyChooseUs $item, array $data): WhyChooseUs
    {
        $item->update($data);
        return $item;
    }

    public function delete(WhyChooseUs $item): bool
    {
        return $item->delete();
    }
}



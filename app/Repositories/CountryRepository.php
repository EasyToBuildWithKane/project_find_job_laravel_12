<?php

namespace App\Repositories;

use App\Models\Country;

class CountryRepository
{
    public function getAll()
    {
        return Country::orderBy('name')->get();
    }

    public function findById(int $id): ?Country
    {
        return Country::find($id);
    }

    public function create(array $data): Country
    {
        return Country::create($data);
    }

    public function update(Country $country, array $data): Country
    {
        $country->update($data);
        return $country;
    }

    public function delete(Country $country): bool
    {
        return $country->delete();
    }
}

<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    /**
     * Lấy tất cả các thành phố
     */
    public function getAll()
    {
        return City::with(['state', 'country'])
            ->orderBy('name')
            ->get();
    }

    /**
     * Tìm thành phố theo ID
     */
    public function findById(int $id): ?City
    {
        return City::with(['state', 'country'])->find($id);
    }

    /**
     * Tạo mới thành phố
     */
    public function create(array $data): City
    {
        return City::create($data);
    }

    /**
     * Cập nhật thông tin thành phố
     */
    public function update(City $city, array $data): City
    {
        $city->update($data);
        return $city;
    }

    /**
     * Xóa thành phố
     */
    public function delete(City $city): bool
    {
        return $city->delete();
    }
}

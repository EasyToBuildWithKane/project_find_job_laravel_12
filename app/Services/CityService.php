<?php

namespace App\Services;

use App\Repositories\CityRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Log;

class CityService
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Lấy toàn bộ danh sách thành phố
     */
    public function getAllCities()
    {
        return $this->cityRepository->getAll();
    }

    /**
     * Lấy thông tin thành phố theo ID
     */
    public function getCityById(int $id)
    {
        try {
            $city = $this->cityRepository->findById($id);

            if (!$city) {
                Log::warning("Không tìm thấy thành phố ID {$id}");
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy thành phố.',
                    'data' => null,
                ];
            }

            return [
                'status' => true,
                'message' => 'Lấy thông tin thành phố thành công.',
                'data' => $city,
            ];
        } catch (Exception $e) {
            Log::error("CityService@getCityById - Lỗi hệ thống khi lấy ID {$id}: {$e->getMessage()}");
            return [
                'status' => false,
                'message' => 'Đã xảy ra lỗi hệ thống, vui lòng thử lại sau.',
                'data' => null,
            ];
        }
    }

    /**
     * Tạo mới thành phố
     */
    public function createCity(array $data)
    {
        return DB::transaction(fn() => $this->cityRepository->create($data));
    }

    /**
     * Cập nhật thành phố
     */
    public function updateCity(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $city = $this->cityRepository->findById($id);
            if (!$city) {
                throw new ModelNotFoundException("Không tìm thấy thành phố ID {$id}");
            }

            return $this->cityRepository->update($city, $data);
        });
    }

    /**
     * Xóa thành phố
     */
    public function deleteCity(int $id)
    {
        return DB::transaction(function () use ($id) {
            $city = $this->cityRepository->findById($id);
            if (!$city) {
                throw new ModelNotFoundException("Không tìm thấy thành phố ID {$id}");
            }

            return $this->cityRepository->delete($city);
        });
    }
}

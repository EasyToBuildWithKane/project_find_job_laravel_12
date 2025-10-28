<?php

namespace App\Services;

use App\Repositories\CountryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Log;

class CountryService
{
    protected $countryRepository;

    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function getAllCountries()
    {
        return $this->countryRepository->getAll();
    }

    public function getCountryById(int $id)
    {
        try {
            $country = $this->countryRepository->findById($id);

            if (!$country) {
                throw new ModelNotFoundException("Country not found with ID {$id}");
            }

            return $country; 
        } catch (ModelNotFoundException $e) {
            Log::warning("Không tìm thấy quốc gia ID {$id}: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error("Lỗi hệ thống khi lấy quốc gia ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }

    public function createCountry(array $data)
    {
        return DB::transaction(fn() => $this->countryRepository->create($data));
    }

    public function updateCountry(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $country = $this->getCountryById($id);
            return $this->countryRepository->update($country, $data);
        });
    }

    public function deleteCountry(int $id)
    {
        return DB::transaction(function () use ($id) {
            $country = $this->getCountryById($id);
            return $this->countryRepository->delete($country);
        });
    }
}

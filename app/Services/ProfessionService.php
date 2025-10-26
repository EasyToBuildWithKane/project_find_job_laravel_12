<?php

namespace App\Services;

use App\Repositories\ProfessionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Log;

class ProfessionService
{
    protected $professionRepository;

    public function __construct(ProfessionRepository $professionRepository)
    {
        $this->professionRepository = $professionRepository;
    }

    public function getAllProfessions()
    {
        return $this->professionRepository->getAll();
    }

    public function getProfessionById(int $id)
    {
        try {
            $profession = $this->professionRepository->findById($id);

            if (!$profession) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy nghề nghiệp.',
                    'data' => null,
                ];
            }

            return [
                'status' => true,
                'message' => 'Lấy thông tin nghề nghiệp thành công.',
                'data' => $profession,
            ];

        } catch (ModelNotFoundException $e) {
            Log::warning("Không tìm thấy nghề nghiệp ID {$id}: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Không tìm thấy nghề nghiệp.',
                'data' => null,
            ];
        } catch (Exception $e) {
            Log::error("Lỗi hệ thống khi lấy nghề nghiệp ID {$id}: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Đã xảy ra lỗi hệ thống, vui lòng thử lại sau.',
                'data' => null,
            ];
        }
    }

    public function createProfession(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->professionRepository->create($data);
        });
    }

    public function updateProfession(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $profession = $this->professionRepository->findById($id);
            return $this->professionRepository->update($profession, $data);
        });
    }

    public function deleteProfession(int $id)
    {
        return DB::transaction(function () use ($id) {
            $profession = $this->professionRepository->findById($id);
            return $this->professionRepository->delete($profession);
        });
    }
}







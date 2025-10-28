<?php

namespace App\Services;

use App\Repositories\SkillRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Log;

class SkillService
{
    protected $skillRepository;

    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    public function getAllSkills()
    {
        return $this->skillRepository->getAll();
    }

    public function getSkillById(int $id)
    {
        try {
            $skill = $this->skillRepository->findById($id);

            if (!$skill) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy kỹ năng.',
                    'data' => null,
                ];
            }

            return [
                'status' => true,
                'message' => 'Lấy thông tin kỹ năng thành công.',
                'data' => $skill,
            ];

        } catch (ModelNotFoundException $e) {
            Log::warning("Không tìm thấy kỹ năng ID {$id}: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Không tìm thấy kỹ năng.',
                'data' => null,
            ];
        } catch (Exception $e) {
            Log::error("Lỗi hệ thống khi lấy kỹ năng ID {$id}: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Đã xảy ra lỗi hệ thống, vui lòng thử lại sau.',
                'data' => null,
            ];
        }
    }

    public function createSkill(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->skillRepository->create($data);
        });
    }

    public function updateSkill(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $skill = $this->skillRepository->findById($id);
            return $this->skillRepository->update($skill, $data);
        });
    }

    public function deleteSkill(int $id)
    {
        return DB::transaction(function () use ($id) {
            $skill = $this->skillRepository->findById($id);
            return $this->skillRepository->delete($skill);
        });
    }
}







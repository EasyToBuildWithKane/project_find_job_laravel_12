<?php

namespace App\Services;

use App\Repositories\StateRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Log;

class StateService
{
    protected $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    /**
     * Lấy danh sách state kèm country (cho DataTables)
     */
    public function getAllStates()
    {
        // Trả về query builder (để DataTables xử lý phân trang server-side)
        return $this->stateRepository->getAllWithCountry();
    }

    /**
     * Tạo state mới
     */
    public function createState(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->stateRepository->create($data);
        });
    }

    /**
     * Cập nhật state
     */
    public function updateState(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $state = $this->stateRepository->findById($id);
            return $this->stateRepository->update($state, $data);
        });
    }

    /**
     * Xóa state
     */
    public function deleteState(int $id)
    {
        return DB::transaction(function () use ($id) {
            $state = $this->stateRepository->findById($id);
            return $this->stateRepository->delete($state);
        });
    }

    /**
     * Lấy chi tiết 1 state
     */
    public function getStateById(int $id)
    {
        try {
            $state = $this->stateRepository->findById($id);

            if (!$state) {
                throw new ModelNotFoundException("State not found with ID {$id}");
            }

            return $state;
        } catch (ModelNotFoundException $e) {
            Log::warning("Không tìm thấy tỉnh/bang ID {$id}: " . $e->getMessage());
            throw $e;
        } catch (Exception $e) {
            Log::error("Lỗi hệ thống khi lấy tỉnh/bang ID {$id}: " . $e->getMessage());
            throw $e;
        }
    }
}

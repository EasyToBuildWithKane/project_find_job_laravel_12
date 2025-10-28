<?php

namespace App\Services;

use App\Repositories\LanguageRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Log;

class LanguageService
{
    protected $languageRepository;

    public function __construct(LanguageRepository $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    public function getAllLanguages()
    {
        return $this->languageRepository->getAll();
    }

    public function getLanguageById(int $id)
    {
        try {
            $language = $this->languageRepository->findById($id);

            if (!$language) {
                return [
                    'status' => false,
                    'message' => 'Không tìm thấy ngôn ngữ.',
                    'data' => null,
                ];
            }

            return [
                'status' => true,
                'message' => 'Lấy thông tin ngôn ngữ thành công.',
                'data' => $language,
            ];

        } catch (ModelNotFoundException $e) {
            Log::warning("Không tìm thấy ngôn ngữ ID {$id}: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Không tìm thấy ngôn ngữ.',
                'data' => null,
            ];
        } catch (Exception $e) {
            Log::error("Lỗi hệ thống khi lấy ngôn ngữ ID {$id}: " . $e->getMessage());

            return [
                'status' => false,
                'message' => 'Đã xảy ra lỗi hệ thống, vui lòng thử lại sau.',
                'data' => null,
            ];
        }
    }

    public function createLanguage(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->languageRepository->create($data);
        });
    }

    public function updateLanguage(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $language = $this->languageRepository->findById($id);
            return $this->languageRepository->update($language, $data);
        });
    }

    public function deleteLanguage(int $id)
    {
        return DB::transaction(function () use ($id) {
            $language = $this->languageRepository->findById($id);
            return $this->languageRepository->delete($language);
        });
    }
}







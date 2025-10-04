<?php

namespace App\Services\Admin\CompanyAbout;

use App\Models\WhyChooseUs;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Throwable;

class WhyChooseUsService
{
    /**
     * Cập nhật thông tin WhyChooseUs
     *
     * @param  WhyChooseUs    $item
     * @param  array          $data
     * @param  UploadedFile|null $iconFile
     * @param  bool           $removeCurrentIcon
     * @return WhyChooseUs
     *
     * @throws QueryException|Throwable
     */
    public function updateItem(
        WhyChooseUs $item,
        array $data,
        ?UploadedFile $iconFile = null,
        bool $removeCurrentIcon = false
    ): WhyChooseUs {
        return DB::transaction(function () use ($item, $data, $iconFile, $removeCurrentIcon) {
            try {
                // Gán dữ liệu cơ bản
                $item->fill([
                    'section_title'    => $data['section_title']    ?? $item->section_title,
                    'section_subtitle' => $data['section_subtitle'] ?? $item->section_subtitle,
                    'item_title'       => $data['item_title']       ?? $item->item_title,
                    'item_description' => $data['item_description'] ?? $item->item_description,
                    'sort_order'       => $data['sort_order']       ?? $item->sort_order,
                    'icon_type'        => $data['icon_type']        ?? $item->icon_type,
                ]);

                // Xoá icon cũ nếu được chọn remove
                if ($removeCurrentIcon) {
                    $this->deleteIcon($item);
                    $item->icon_value = null;
                }

                // Upload icon mới nếu loại là image
                if ($iconFile && $iconFile->isValid()) {
                    $this->deleteIcon($item);
                    $item->icon_value = $this->uploadIcon($iconFile);
                    $item->icon_type = 'image';
                } else {
                    // Nếu icon_type là class hoặc svg -> gán trực tiếp
                    if (!empty($data['icon_value']) && in_array($item->icon_type, ['class', 'svg'])) {
                        $item->icon_value = $data['icon_value'];
                    }
                }

                $item->save();

                return $item;
            } catch (Throwable $e) {
                Log::error('WhyChooseUs update failed', [
                    'item_id' => $item->id,
                    'data'    => $data,
                    'error'   => $e->getMessage(),
                    'trace'   => $e->getTraceAsString(),
                ]);
                throw $e;
            }
        });
    }

    /**
     * Upload icon image
     */
    private function uploadIcon(UploadedFile $file): string
    {
        $path = $file->storeAs(
            'uploads/why_choose_us',
            now()->format('YmdHis') . '_' . $file->getClientOriginalName(),
            'public'
        );

        return 'storage/' . $path;
    }

    /**
     * Xoá icon hiện tại (nếu là image)
     */
    private function deleteIcon(WhyChooseUs $item): void
    {
        if ($item->icon_type === 'image' && $item->icon_value) {
            $relativePath = str_replace('storage/', '', $item->icon_value);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }
    }
}

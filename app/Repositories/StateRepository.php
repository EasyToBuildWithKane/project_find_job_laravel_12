<?php

namespace App\Repositories;

use App\Models\State;

class StateRepository
{
    /**
     * Lấy toàn bộ danh sách state (kèm country)
     */
    public function getAllWithCountry()
    {
        // Eager load quan hệ country, tránh N+1
        return State::with('country')->select('states.*')->orderBy('name');
    }

    /**
     * Lấy toàn bộ danh sách state (nếu không cần country)
     */
    public function getAll()
    {
        return State::orderBy('name')->get();
    }

    /**
     * Tìm state theo ID
     */
    public function findById(int $id): ?State
    {
        return State::find($id);
    }

    /**
     * Tạo state mới
     */
    public function create(array $data): State
    {
        return State::create($data);
    }

    /**
     * Cập nhật state
     */
    public function update(State $state, array $data): State
    {
        $state->update($data);
        return $state;
    }

    /**
     * Xóa state
     */
    public function delete(State $state): bool
    {
        return $state->delete();
    }
}



<?php

namespace App\Repositories;

use App\Models\Language;

class LanguageRepository
{
    public function getAll()
    {
        return Language::orderBy('name')->get();
    }

    public function findById(int $id): ?Language
    {
        return Language::find($id);
    }

    public function create(array $data): Language
    {
        return Language::create($data);
    }

    public function update(Language $language, array $data): Language
    {
        $language->update($data);
        return $language;
    }

    public function delete(Language $language): bool
    {
        return $language->delete();
    }
}







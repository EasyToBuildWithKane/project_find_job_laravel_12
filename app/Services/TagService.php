<?php

namespace App\Services;

use App\Repositories\TagRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Log;

class TagService
{
    protected $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags()
    {
        return $this->tagRepository->getAll();
    }

    public function createTag(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->tagRepository->create($data);
        });
    }

    public function updateTag(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $tag = $this->tagRepository->findById($id);
            return $this->tagRepository->update($tag, $data);
        });
    }

    public function deleteTag(int $id)
    {
        return DB::transaction(function () use ($id) {
            $tag = $this->tagRepository->findById($id);
            return $this->tagRepository->delete($tag);
        });
    }
}







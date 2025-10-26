<?php

namespace App\Services;

use App\Repositories\BlogRepository;
use Illuminate\Support\Facades\DB;
use Exception;
use Log;

class BlogService
{
    protected $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    public function getAllBlogs()
    {
        return $this->blogRepository->getAll();
    }

    public function createBlog(array $data)
    {
        return DB::transaction(function () use ($data) {
            return $this->blogRepository->create($data);
        });
    }

    public function updateBlog(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $blog = $this->blogRepository->findById($id);
            return $this->blogRepository->update($blog, $data);
        });
    }

    public function deleteBlog(int $id)
    {
        return DB::transaction(function () use ($id) {
            $blog = $this->blogRepository->findById($id);
            return $this->blogRepository->delete($blog);
        });
    }
}







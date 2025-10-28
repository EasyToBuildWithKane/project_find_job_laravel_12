<?php

namespace App\Repositories;

use App\Models\Blog;

class BlogRepository
{
    public function getAll()
    {
        return Blog::orderByDesc('id')->get();
    }

    public function findById(int $id): ?Blog
    {
        return Blog::find($id);
    }

    public function create(array $data): Blog
    {
        return Blog::create($data);
    }

    public function update(Blog $blog, array $data): Blog
    {
        $blog->update($data);
        return $blog;
    }

    public function delete(Blog $blog): bool
    {
        return $blog->delete();
    }
}







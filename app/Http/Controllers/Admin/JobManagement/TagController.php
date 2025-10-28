<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\TagRequest;
use App\Services\TagService;
use Exception;
use Log;

class TagController extends Controller
{
    protected $tagService;

    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }

    public function index()
    {
        $tags = $this->tagService->getAllTags();
        return view('admin.job_management.tags.index', compact('tags'));
    }

    public function store(TagRequest $request)
    {
        try {
            $this->tagService->createTag($request->validated());
            return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo tag: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo tag.']);
        }
    }

    public function update(TagRequest $request, $id)
    {
        try {
            $this->tagService->updateTag($id, $request->validated());
            return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật tag: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật tag.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->tagService->deleteTag($id);
            return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa tag: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa tag.']);
        }
    }
}



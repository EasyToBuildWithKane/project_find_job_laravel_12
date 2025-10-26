<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobTagRequest;
use App\Services\JobTagService;
use Exception;
use Log;

class JobTagController extends Controller
{
    protected $jobTagService;

    public function __construct(JobTagService $jobTagService)
    {
        $this->jobTagService = $jobTagService;
    }

    public function index()
    {
        $items = $this->jobTagService->getAllJobTags();
        return view('admin.job_management.job_tags.index', compact('items'));
    }

    public function store(JobTagRequest $request)
    {
        try {
            $this->jobTagService->createJobTag($request->validated());
            return redirect()->route('admin.job_tags.index')->with('success', 'Job-tag created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo job-tag: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo job-tag.']);
        }
    }

    public function update(JobTagRequest $request, $id)
    {
        try {
            $this->jobTagService->updateJobTag($id, $request->validated());
            return redirect()->route('admin.job_tags.index')->with('success', 'Job-tag updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật job-tag: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật job-tag.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobTagService->deleteJobTag($id);
            return redirect()->route('admin.job_tags.index')->with('success', 'Job-tag deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa job-tag: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa job-tag.']);
        }
    }
}



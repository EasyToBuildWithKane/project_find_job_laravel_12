<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobSkillsRequest;
use App\Services\JobSkillsService;
use Exception;
use Log;

class JobSkillsController extends Controller
{
    protected $jobSkillsService;

    public function __construct(JobSkillsService $jobSkillsService)
    {
        $this->jobSkillsService = $jobSkillsService;
    }

    public function index()
    {
        $items = $this->jobSkillsService->getAllJobSkills();
        return view('admin.job_management.job_skills.index', compact('items'));
    }

    public function store(JobSkillsRequest $request)
    {
        try {
            $this->jobSkillsService->createJobSkills($request->validated());
            return redirect()->route('admin.job_skills.index')->with('success', 'Job-skill created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo job-skill: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo job-skill.']);
        }
    }

    public function update(JobSkillsRequest $request, $id)
    {
        try {
            $this->jobSkillsService->updateJobSkills($id, $request->validated());
            return redirect()->route('admin.job_skills.index')->with('success', 'Job-skill updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật job-skill: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật job-skill.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobSkillsService->deleteJobSkills($id);
            return redirect()->route('admin.job_skills.index')->with('success', 'Job-skill deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa job-skill: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa job-skill.']);
        }
    }
}



<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\SkillRequest;
use App\Services\SkillService;
use Exception;
use Log;

class SkillController extends Controller
{
    protected $skillService;

    public function __construct(SkillService $skillService)
    {
        $this->skillService = $skillService;
    }

    public function index()
    {
        $skills = $this->skillService->getAllSkills();
        return view('admin.job_management.skills.index', compact('skills'));
    }

    public function store(SkillRequest $request)
    {
        try {
            $this->skillService->createSkill($request->validated());
            return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo kỹ năng: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo kỹ năng.']);
        }
    }

    public function update(SkillRequest $request, $id)
    {
        try {
            $this->skillService->updateSkill($id, $request->validated());
            return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật kỹ năng: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật kỹ năng.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->skillService->deleteSkill($id);
            return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa kỹ năng: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa kỹ năng.']);
        }
    }
}



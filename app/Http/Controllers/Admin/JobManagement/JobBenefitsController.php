<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobBenefitsRequest;
use App\Services\JobBenefitsService;
use Exception;
use Log;

class JobBenefitsController extends Controller
{
    protected $jobBenefitsService;

    public function __construct(JobBenefitsService $jobBenefitsService)
    {
        $this->jobBenefitsService = $jobBenefitsService;
    }

    public function index()
    {
        $items = $this->jobBenefitsService->getAllJobBenefits();
        return view('admin.job_management.job_benefits.index', compact('items'));
    }

    public function store(JobBenefitsRequest $request)
    {
        try {
            $this->jobBenefitsService->createJobBenefits($request->validated());
            return redirect()->route('admin.job_benefits.index')->with('success', 'Job-benefit created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo job-benefit: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo job-benefit.']);
        }
    }

    public function update(JobBenefitsRequest $request, $id)
    {
        try {
            $this->jobBenefitsService->updateJobBenefits($id, $request->validated());
            return redirect()->route('admin.job_benefits.index')->with('success', 'Job-benefit updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật job-benefit: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật job-benefit.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobBenefitsService->deleteJobBenefits($id);
            return redirect()->route('admin.job_benefits.index')->with('success', 'Job-benefit deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa job-benefit: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa job-benefit.']);
        }
    }
}



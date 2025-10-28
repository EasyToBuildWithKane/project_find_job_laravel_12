<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\BenefitsRequest;
use App\Services\BenefitsService;
use Exception;
use Log;

class BenefitsController extends Controller
{
    protected $benefitsService;

    public function __construct(BenefitsService $benefitsService)
    {
        $this->benefitsService = $benefitsService;
    }

    public function index()
    {
        $benefits = $this->benefitsService->getAllBenefits();
        return view('admin.job_management.benefits.index', compact('benefits'));
    }

    public function store(BenefitsRequest $request)
    {
        try {
            $this->benefitsService->createBenefits($request->validated());
            return redirect()->route('admin.benefits.index')->with('success', 'Benefit created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo phúc lợi: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo phúc lợi.']);
        }
    }

    public function update(BenefitsRequest $request, $id)
    {
        try {
            $this->benefitsService->updateBenefits($id, $request->validated());
            return redirect()->route('admin.benefits.index')->with('success', 'Benefit updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật phúc lợi: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật phúc lợi.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->benefitsService->deleteBenefits($id);
            return redirect()->route('admin.benefits.index')->with('success', 'Benefit deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa phúc lợi: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa phúc lợi.']);
        }
    }
}



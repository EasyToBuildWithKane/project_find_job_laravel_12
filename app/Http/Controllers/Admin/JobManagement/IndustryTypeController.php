<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\IndustryTypeRequest;
use App\Services\IndustryTypeService;
use Exception;
use Log;

class IndustryTypeController extends Controller
{
    protected $industryTypeService;

    public function __construct(IndustryTypeService $industryTypeService)
    {
        $this->industryTypeService = $industryTypeService;
    }

    public function index()
    {
        $items = $this->industryTypeService->getAllIndustryTypes();
        return view('admin.job_management.industry_types.index', compact('items'));
    }

    public function store(IndustryTypeRequest $request)
    {
        try {
            $this->industryTypeService->createIndustryType($request->validated());
            return redirect()->route('admin.industry_types.index')->with('success', 'Industry type created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo ngành nghề: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo ngành nghề.']);
        }
    }

    public function update(IndustryTypeRequest $request, $id)
    {
        try {
            $this->industryTypeService->updateIndustryType($id, $request->validated());
            return redirect()->route('admin.industry_types.index')->with('success', 'Industry type updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật ngành nghề: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật ngành nghề.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->industryTypeService->deleteIndustryType($id);
            return redirect()->route('admin.industry_types.index')->with('success', 'Industry type deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa ngành nghề: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa ngành nghề.']);
        }
    }
}



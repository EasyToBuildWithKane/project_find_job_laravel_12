<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\OrganizationTypeRequest;
use App\Services\OrganizationTypeService;
use Exception;
use Log;

class OrganizationTypeController extends Controller
{
    protected $organizationTypeService;

    public function __construct(OrganizationTypeService $organizationTypeService)
    {
        $this->organizationTypeService = $organizationTypeService;
    }

    public function index()
    {
        $items = $this->organizationTypeService->getAllOrganizationTypes();
        return view('admin.job_management.organization_types.index', compact('items'));
    }

    public function store(OrganizationTypeRequest $request)
    {
        try {
            $this->organizationTypeService->createOrganizationType($request->validated());
            return redirect()->route('admin.organization_types.index')->with('success', 'Organization type created successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi tạo loại tổ chức: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể tạo loại tổ chức.']);
        }
    }

    public function update(OrganizationTypeRequest $request, $id)
    {
        try {
            $this->organizationTypeService->updateOrganizationType($id, $request->validated());
            return redirect()->route('admin.organization_types.index')->with('success', 'Organization type updated successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi cập nhật loại tổ chức: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể cập nhật loại tổ chức.']);
        }
    }

    public function destroy($id)
    {
        try {
            $this->organizationTypeService->deleteOrganizationType($id);
            return redirect()->route('admin.organization_types.index')->with('success', 'Organization type deleted successfully.');
        } catch (Exception $e) {
            Log::error('Lỗi xóa loại tổ chức: '.$e->getMessage());
            return back()->withErrors(['error' => 'Không thể xóa loại tổ chức.']);
        }
    }
}



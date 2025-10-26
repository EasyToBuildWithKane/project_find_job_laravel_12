<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\CompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class CompanyController extends Controller
{
    protected $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->companyService->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.companies.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }
        return view('admin.job_management.companies.index');
    }

    public function create()
    {
        return view('admin.job_management.companies.create');
    }

    public function store(CompanyRequest $request)
    {
        try {
            $this->companyService->create($request->validated());
            return redirect()->route('admin.companies.index')->with('success', '✅ Thêm mới công ty thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới công ty: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '❌ Có lỗi xảy ra khi thêm mới công ty!');
        }
    }

    public function edit($id)
    {
        try {
            $company = $this->companyService->find($id);
            return view('admin.job_management.companies.edit', compact('company'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy công ty để sửa: ' . $e->getMessage());
            return redirect()->route('admin.companies.index')->with('error', '❌ Không tìm thấy công ty!');
        }
    }

    public function update(CompanyRequest $request, $id)
    {
        try {
            $this->companyService->update($id, $request->validated());
            return redirect()->route('admin.companies.index')->with('success', '✅ Cập nhật công ty thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật công ty: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '❌ Có lỗi xảy ra khi cập nhật công ty!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->companyService->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa công ty thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa công ty: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Có lỗi xảy ra khi xóa công ty!'], 500);
        }
    }
}

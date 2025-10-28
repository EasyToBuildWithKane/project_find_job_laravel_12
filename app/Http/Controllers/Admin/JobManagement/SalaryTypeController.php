<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\SalaryTypeRequest;
use App\Services\SalaryTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class SalaryTypeController extends Controller
{
    protected $salaryTypeService;

    public function __construct(SalaryTypeService $salaryTypeService)
    {
        $this->salaryTypeService = $salaryTypeService;
    }

    /**
     * Danh sách loại lương
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->salaryTypeService->getAll();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.salary_types.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }

        return view('admin.job_management.salary_types.index');
    }

    /**
     * Form thêm mới loại lương
     */
    public function create()
    {
        return view('admin.job_management.salary_types.create');
    }

    /**
     * Lưu loại lương mới
     */
    public function store(SalaryTypeRequest $request)
    {
        try {
            $this->salaryTypeService->create($request->validated());
            return redirect()
                ->route('admin.salary_types.index')
                ->with('success', '✅ Thêm mới loại lương thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới loại lương: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '❌ Có lỗi xảy ra khi thêm mới loại lương!');
        }
    }

    /**
     * Form chỉnh sửa loại lương
     */
    public function edit($id)
    {
        try {
            $salaryType = $this->salaryTypeService->find($id);
            return view('admin.job_management.salary_types.edit', compact('salaryType'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy loại lương để sửa: ' . $e->getMessage());
            return redirect()
                ->route('admin.salary_types.index')
                ->with('error', '❌ Không tìm thấy loại lương!');
        }
    }

    /**
     * Cập nhật loại lương
     */
    public function update(SalaryTypeRequest $request, $id)
    {
        try {
            $this->salaryTypeService->update($id, $request->validated());
            return redirect()
                ->route('admin.salary_types.index')
                ->with('success', '✅ Cập nhật loại lương thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật loại lương: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', '❌ Có lỗi xảy ra khi cập nhật loại lương!');
        }
    }

    /**
     * Xóa loại lương
     */
    public function destroy($id)
    {
        try {
            $this->salaryTypeService->delete($id);
            return response()->json([
                'success' => true,
                'message' => '✅ Xóa loại lương thành công!'
            ]);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa loại lương: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => '❌ Có lỗi xảy ra khi xóa loại lương!'
            ], 500);
        }
    }
}

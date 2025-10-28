<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobCategoryRequest;
use App\Services\JobCategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class JobCategoryController extends Controller
{
    protected $jobCategoryService;

    public function __construct(JobCategoryService $jobCategoryService)
    {
        $this->jobCategoryService = $jobCategoryService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->jobCategoryService->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.job_categories.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }

        return view('admin.job_management.job_categories.index');
    }

    public function create()
    {
        return view('admin.job_management.job_categories.create');
    }

    public function store(JobCategoryRequest $request)
    {
        try {
            $this->jobCategoryService->create($request->validated());
            return redirect()->route('admin.job_categories.index')->with('success', '✅ Thêm mới thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới job_category: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        try {
            $category = $this->jobCategoryService->find($id);
            return view('admin.job_management.job_categories.edit', compact('category'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy job_category: ' . $e->getMessage());
            return redirect()->route('admin.job_categories.index')->with('error', '❌ Không tìm thấy bản ghi!');
        }
    }

    public function update(JobCategoryRequest $request, $id)
    {
        try {
            $this->jobCategoryService->update($id, $request->validated());
            return redirect()->route('admin.job_categories.index')->with('success', '✅ Cập nhật thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật job_category: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobCategoryService->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa job_category: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Không thể xóa!'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobTypeRequest;
use App\Services\JobTypeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class JobTypeController extends Controller
{
    protected $jobTypeService;

    public function __construct(JobTypeService $jobTypeService)
    {
        $this->jobTypeService = $jobTypeService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->jobTypeService->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.job_types.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }
        return view('admin.job_management.job_types.index');
    }

    public function create()
    {
        return view('admin.job_management.job_types.create');
    }

    public function store(JobTypeRequest $request)
    {
        try {
            $this->jobTypeService->create($request->validated());
            return redirect()->route('admin.job_types.index')->with('success', '✅ Thêm mới thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới job type: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        try {
            $jobType = $this->jobTypeService->find($id);
            return view('admin.job_management.job_types.edit', compact('jobType'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy job type: ' . $e->getMessage());
            return redirect()->route('admin.job_types.index')->with('error', '❌ Không tìm thấy!');
        }
    }

    public function update(JobTypeRequest $request, $id)
    {
        try {
            $this->jobTypeService->update($id, $request->validated());
            return redirect()->route('admin.job_types.index')->with('success', '✅ Cập nhật thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật job type: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobTypeService->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa job type: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Không thể xóa!'], 500);
        }
    }
}

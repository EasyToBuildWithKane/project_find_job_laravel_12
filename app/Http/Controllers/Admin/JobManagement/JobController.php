<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobRequest;
use App\Services\JobService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Throwable;

class JobController extends Controller
{
    protected $service;

    public function __construct(JobService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->service->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('company', fn($row) => $row->company?->name ?? '-')
                ->addColumn('category', fn($row) => $row->category?->name ?? '-')
                ->addColumn('role', fn($row) => $row->role?->name ?? '-')
                ->addColumn('job_type', fn($row) => $row->jobType?->name ?? '-')
                ->addColumn('salary_type', fn($row) => $row->salaryType?->name ?? '-')
                ->addColumn('action', fn($row) => view('admin.job_management.jobs.partials.actions', compact('row'))->render())
                ->make(true);
        }
        return view('admin.job_management.jobs.index');
    }

    public function create()
    {
        return view('admin.job_management.jobs.create');
    }

    public function store(JobRequest $request)
    {
        try {
            $this->service->create($request->validated());
            return redirect()->route('admin.jobs.index')->with('success', '✅ Thêm mới công việc thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới công việc: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '❌ Có lỗi xảy ra khi thêm mới công việc!');
        }
    }

    public function edit($id)
    {
        try {
            $job = $this->service->find($id);
            return view('admin.job_management.jobs.edit', compact('job'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy công việc: ' . $e->getMessage());
            return redirect()->route('admin.jobs.index')->with('error', '❌ Không tìm thấy công việc!');
        }
    }

    public function update(JobRequest $request, $id)
    {
        try {
            $this->service->update($id, $request->validated());
            return redirect()->route('admin.jobs.index')->with('success', '✅ Cập nhật công việc thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật công việc: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', '❌ Có lỗi xảy ra khi cập nhật công việc!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa công việc thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa công việc: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Có lỗi xảy ra khi xóa công việc!'], 500);
        }
    }
}

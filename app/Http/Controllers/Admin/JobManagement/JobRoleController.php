<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobRoleRequest;
use App\Services\JobRoleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class JobRoleController extends Controller
{
    protected $jobRoleService;

    public function __construct(JobRoleService $jobRoleService)
    {
        $this->jobRoleService = $jobRoleService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->jobRoleService->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.job_roles.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }

        return view('admin.job_management.job_roles.index');
    }

    public function create()
    {
        return view('admin.job_management.job_roles.create');
    }

    public function store(JobRoleRequest $request)
    {
        try {
            $this->jobRoleService->create($request->validated());
            return redirect()->route('admin.job_roles.index')->with('success', '✅ Thêm mới thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới job_role: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        try {
            $role = $this->jobRoleService->find($id);
            return view('admin.job_management.job_roles.edit', compact('role'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy job_role: ' . $e->getMessage());
            return redirect()->route('admin.job_roles.index')->with('error', '❌ Không tìm thấy bản ghi!');
        }
    }

    public function update(JobRoleRequest $request, $id)
    {
        try {
            $this->jobRoleService->update($id, $request->validated());
            return redirect()->route('admin.job_roles.index')->with('success', '✅ Cập nhật thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật job_role: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobRoleService->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa job_role: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Không thể xóa!'], 500);
        }
    }
}

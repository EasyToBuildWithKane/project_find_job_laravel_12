<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\JobExperienceRequest;
use App\Services\JobExperienceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class JobExperienceController extends Controller
{
    protected $jobExperienceService;

    public function __construct(JobExperienceService $jobExperienceService)
    {
        $this->jobExperienceService = $jobExperienceService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->jobExperienceService->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.job_experiences.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }

        return view('admin.job_management.job_experiences.index');
    }

    public function create()
    {
        return view('admin.job_management.job_experiences.create');
    }

    public function store(JobExperienceRequest $request)
    {
        try {
            $this->jobExperienceService->create($request->validated());
            return redirect()->route('admin.job_experiences.index')->with('success', '✅ Thêm mới thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới job_experience: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        try {
            $experience = $this->jobExperienceService->find($id);
            return view('admin.job_management.job_experiences.edit', compact('experience'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy job_experience: ' . $e->getMessage());
            return redirect()->route('admin.job_experiences.index')->with('error', '❌ Không tìm thấy bản ghi!');
        }
    }

    public function update(JobExperienceRequest $request, $id)
    {
        try {
            $this->jobExperienceService->update($id, $request->validated());
            return redirect()->route('admin.job_experiences.index')->with('success', '✅ Cập nhật thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật job_experience: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->jobExperienceService->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa job_experience: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Không thể xóa!'], 500);
        }
    }
}

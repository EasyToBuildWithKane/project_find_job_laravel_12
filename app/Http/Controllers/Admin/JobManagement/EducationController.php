<?php

namespace App\Http\Controllers\Admin\JobManagement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobManagement\EducationRequest;
use App\Services\EducationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Throwable;

class EducationController extends Controller
{
    protected $educationService;

    public function __construct(EducationService $educationService)
    {
        $this->educationService = $educationService;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->educationService->getAll();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.job_management.education.partials.actions', compact('row'))->render();
                })
                ->make(true);
        }
        return view('admin.job_management.education.index');
    }

    public function create()
    {
        return view('admin.job_management.education.create');
    }

    public function store(EducationRequest $request)
    {
        try {
            $this->educationService->create($request->validated());
            return redirect()->route('admin.education.index')->with('success', '✅ Thêm mới thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi thêm mới education: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function edit($id)
    {
        try {
            $education = $this->educationService->find($id);
            return view('admin.job_management.education.edit', compact('education'));
        } catch (Throwable $e) {
            Log::error('Lỗi lấy education: ' . $e->getMessage());
            return redirect()->route('admin.education.index')->with('error', '❌ Không tìm thấy!');
        }
    }

    public function update(EducationRequest $request, $id)
    {
        try {
            $this->educationService->update($id, $request->validated());
            return redirect()->route('admin.education.index')->with('success', '✅ Cập nhật thành công!');
        } catch (Throwable $e) {
            Log::error('Lỗi cập nhật education: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra!');
        }
    }

    public function destroy($id)
    {
        try {
            $this->educationService->delete($id);
            return response()->json(['success' => true, 'message' => '✅ Xóa thành công!']);
        } catch (Throwable $e) {
            Log::error('Lỗi xóa education: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => '❌ Không thể xóa!'], 500);
        }
    }
}
